<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\ArtworkRepository;
use App\Repository\CartArtworkRepository;
use App\Repository\CartRepository;
use App\Entity\Order;
use App\Repository\UserRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use function PHPSTORM_META\map;

#[Route('/order')]
class OrderController extends AbstractController
{
    // EN ESTE SE INTENTA IMPLEMENTAR LA CONFIRMACIÓN DEL PAGO AQUI
    #[Route('/new', name: 'order_new', methods: ['POST'])]
    public function newOrder(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, UserRepository $userRepository, ArtworkRepository $artworkRepository, CartRepository $cartRepository, CartArtworkRepository $cartArtworkRepository): Response
    {

        $data = json_decode($request->getContent(), true);

        if (!isset($data['orderData'], $data['paymentData'])) {
            return new JsonResponse(['error' => 'Datos incompletos'], 400);
        }

        // Datos de pago
        $paymentData = $data['paymentData'];
        $paymentIntentId = $paymentData['payment_intent_id'];
        $billingDetails = $paymentData['billing_details'];
        $token = $paymentData['token'];

        // Datos del pedido
        $orderData = $data['orderData'];

        // Definir la clave secreta de Stripe
        Stripe::setApiKey('sk_test_51QL60A01qslkTUyp5Up7izZk9E246evOANRPdqRYBzVvurm7H2tgVcBEK5kM24ZxuQzXjz9wkgWEwoWS5JBMFk2a00zAkNeYbE');

        try {
            $entityManager->beginTransaction();

            $paymentMethod = PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'token' => $token,
                ],
                'billing_details' => [
                    'name' => $billingDetails['name'],
                    'email' => $billingDetails['email'],
                    'address' => [
                        'line1' => $billingDetails['address']['line1'],
                        'line2' => $billingDetails['address']['line2'],
                        'postal_code' => $billingDetails['address']['postal_code'],
                        'city' => $billingDetails['address']['city'],
                    ],
                ],
            ]);

            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            $paymentIntent->confirm([
                'payment_method' => $paymentMethod->id,
                'return_url' => 'http://localhost:4200/userdata/pedidos', // URL a la que se redirige después del pago
            ]);

            // Verificar que el estado del pago es 'succeeded'
            if ($paymentIntent->status !== 'succeeded') {
                return new JsonResponse(['error' => 'El pago no fue procesado correctamente'], 404);
            }

            $order = new Order();

            $user = $userRepository->find($orderData['user_id']);
            if (!$user) {
                return new JsonResponse(['error' => 'Usuario no encontrado'], 404);
            }
            $cart = $cartRepository->find($orderData['cart_id']);
            if (!$cart) {
                return new JsonResponse(['error' => 'Carrito no encontrado'], 404);
            }

            $total_amount = $orderData['total_amount'];
            if (!$total_amount) {
                return new JsonResponse(['error' => 'Precio total no encontrado'], 404);
            }

            $order->setUser($user);
            $order->setTotalAmount($total_amount);
            $order->setCreatedAt(new DateTimeImmutable('now'));
            $userAddress = $user->getAddressJson();
            $order->setAddress($userAddress);
            $order->setStatus('pending');
            $entityManager->persist($order);
            $entityManager->flush();


            // Artworks asociados al carrito actual
            $cartArtworks = $cart->getCartArtworks();
            foreach ($cartArtworks as $cartArtwork) {
                if ($cartArtwork->isSelected()) {
                    $entityManager->remove($cartArtwork);
                }
            }
            $entityManager->persist($cart);
            $entityManager->flush();

            // Por cada obra que se está comprando
            $artworks = $orderData['artworks'];
            foreach ($artworks as $artwork_id) {
                $artwork = $artworkRepository->find($artwork_id);
                if (!$artwork) {
                    return new JsonResponse(['error' => 'Obra de arte no encontrada'], 404);
                }
                if ($artwork->isSold()) {
                    return new JsonResponse(['error' => 'La obra que está intentando comprar ya está vendida'], 404);
                }
                if (!$artwork->isSold()) {
                    $artwork->setSold(true);
                    $artwork->setOrderId($order);

                    // Todos los carritos de todos los usuarios en los que está esta obra
                    $allcarts = $artwork->getCartArtworks();
                    foreach ($allcarts as $cartArtwork) {
                        $cartArtwork->setSelected(false);
                        $entityManager->persist($cartArtwork);
                    }

                    $entityManager->persist($artwork);
                    $entityManager->flush();
                }
            }


            $entityManager->persist($order);
            $entityManager->flush();

            $entityManager->commit();

            $email = (new Email())
                ->from('samurbinx@gmail.com')
                ->to($user->getEmail())
                ->subject('AESMA')
                ->text('Su pedido Nº'.$order->getId().' ha sido realizado con éxito');

            $mailer->send($email);

            return new JsonResponse([
                'message' => 'Se ha completado el pedido',
                'order' => $order,
                'artworks' => $order->getArtworks()
            ], 200);
        } catch (\Exception $e) {
            $entityManager->rollback();

            // Cancelar el pago en Stripe si el pedido no fue creado correctamente
            if (isset($paymentIntent)) {
                $paymentIntent->cancel();
            }

            // Retornar el error
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}
