<?php

namespace App\Controller;

use App\Entity\CartArtwork;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\WorkRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\ArtworkRepository;
use App\Repository\CartArtworkRepository;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;

#[Route('/cart')]

class CartController extends AbstractController
{

    public function __construct()
    {
        // Clave secreta de Stripe
        Stripe::setApiKey('sk_test_51QL60A01qslkTUyp5Up7izZk9E246evOANRPdqRYBzVvurm7H2tgVcBEK5kM24ZxuQzXjz9wkgWEwoWS5JBMFk2a00zAkNeYbE');
    }

    #[Route('/', name: 'app_cart')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    #[Route('/addArtwork', name: 'app_cart_add', methods: ['POST'])]
    public function addArtwork(Request $request, EntityManagerInterface $entityManager, CartRepository $cartRepository, ArtworkRepository $artworkRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['cart_id'], $data['artwork_id'])) {
            return new JsonResponse(['error' => 'Datos incompletos'], 400);
        }

        $cart = $cartRepository->find($data['cart_id']);
        $artwork = $artworkRepository->find($data['artwork_id']);

        if (!$cart || !$artwork) {
            return new JsonResponse(['error' => 'Carrito o obra de arte no encontrado'], 404);
        }
        
        try {
            $cartArtwork = new CartArtwork();
            $cartArtwork->setCart($cart);
            $cartArtwork->setArtwork($artwork);
            $entityManager->persist($cartArtwork);

            $cart->addCartArtwork($cartArtwork);
            $entityManager->persist($cartArtwork);
            $entityManager->persist($cart);
            $entityManager->flush();

            return new JsonResponse([
                'message' => 'Se ha añadido la obra al carrito',
                'cart_id' => $cart->getId(),
                'artwork_id' => $artwork->getId(),
                'cart_length' => $cart->getLength()
            ], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error al añadir la obra al carrito: ' . $e->getMessage()], 500);
        }
    }


    #[Route('/delArtwork', name: 'app_cart_del', methods: ['POST'])]
    public function delArtwork(Request $request, EntityManagerInterface $entityManager, CartRepository $cartRepository, CartArtworkRepository $cartArtworkRepository, ArtworkRepository $artworkRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['cart_id'], $data['artwork_id'])) {
            return new JsonResponse(['error' => 'Datos incompletos'], 400);
        }

        $cart = $cartRepository->find($data['cart_id']);
        $artwork = $artworkRepository->find($data['artwork_id']);

        if (!$cart || !$artwork) {
            return new JsonResponse(['error' => 'Carrito o obra de arte no encontrado'], 404);
        }

        $cartArtwork = $cartArtworkRepository->findOneBy([
            'Cart' => $cart,
            'Artwork' => $artwork,
        ]);
        if (!$cartArtwork) {
            return new JsonResponse(['error' => 'La obra no está asociada al carrito'], 404);
        }

        $cart->removeCartArtwork($cartArtwork);
        $entityManager->remove($cartArtwork);
        $entityManager->persist($cart);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Se ha eliminado la obra del carrito',
            'cart_id' => $cart->getId(),
            'cartartwork_id' => $cartArtwork->getId(),
            'artwork_id' => $artwork->getId()
        ], 200);
    }

    #[Route('/{cart_id}/getCartArtworks', name: 'app_cartartwork_get', methods: ['GET'])]
    public function getCartArtworks(int $cart_id, Request $request, EntityManagerInterface $entityManager, CartRepository $cartRepository, CartArtworkRepository $cartArtworkRepository, ArtworkRepository $artworkRepository): Response
    {
        $cart = $cartRepository->find($cart_id);

        if (!$cart) {
            return new JsonResponse(['error' => 'Carrito no encontrado'], 404);
        }

        $cartArtworks = $cart->getCartArtworksJson();
        if (!$cartArtworks) {
            return new JsonResponse(['error' => 'No hay ninguna obra en el carrito'], 404);
        }

        return new JsonResponse($cartArtworks, 200);
    }

    #[Route('/{cart_id}/getCartLength', name: 'app_cartlength_get', methods: ['GET'])]
    public function getCartLength(int $cart_id, Request $request, EntityManagerInterface $entityManager, CartRepository $cartRepository, CartArtworkRepository $cartArtworkRepository, ArtworkRepository $artworkRepository): Response
    {
        $cart = $cartRepository->find($cart_id);

        if (!$cart) {
            return new JsonResponse(['error' => 'Carrito no encontrado'], 404);
        }

        $cartlength = $cart->getLength();
        if (!$cartlength) {
            return new JsonResponse(['error' => 'No hay ninguna obra en el carrito'], 404);
        }

        return new JsonResponse($cartlength, 200);
    }

    #[Route('/toggleSelected', name: 'app_cart_selected', methods: ['POST'])]
    public function toggleSelected(Request $request, EntityManagerInterface $entityManager, CartRepository $cartRepository, CartArtworkRepository $cartArtworkRepository, ArtworkRepository $artworkRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['cart_id'], $data['artwork_id'])) {
            return new JsonResponse(['error' => 'Datos incompletos'], 400);
        }

        $cart = $cartRepository->find($data['cart_id']);
        $artwork = $artworkRepository->find($data['artwork_id']);

        if (!$cart || !$artwork) {
            return new JsonResponse(['error' => 'Carrito o obra de arte no encontrado'], 404);
        }

        $cartArtwork = $cartArtworkRepository->findOneBy([
            'Cart' => $cart,
            'Artwork' => $artwork,
        ]);
        if (!$cartArtwork) {
            return new JsonResponse(['error' => 'La obra no está asociada al carrito'], 404);
        }

        $cartArtwork->setSelected(!$cartArtwork->isSelected());

        $entityManager->persist($cartArtwork);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'El estado de selección de la obra ha sido cambiado',
            'cart_id' => $cart->getId(),
            'artwork_id' => $artwork->getId()
        ], 200);
    }


    #[Route('/isSelected/{cart_id}/{artwork_id}', name: 'app_cart_isselected', methods: ['GET'])]
    public function isSelected(Request $request, int $cart_id, int $artwork_id, CartRepository $cartRepository, CartArtworkRepository $cartArtworkRepository, ArtworkRepository $artworkRepository): Response
    {

        if (!$cart_id || !$artwork_id) {
            return new JsonResponse(['error' => 'Datos incompletos'], 400);
        }


        $cart = $cartRepository->find($cart_id);
        $artwork = $artworkRepository->find($artwork_id);

        if (!$cart || !$artwork) {
            return new JsonResponse(['error' => 'Carrito o obra de arte no encontrado'], 404);
        }

        $cartArtwork = $cartArtworkRepository->findOneBy([
            'Cart' => $cart,
            'Artwork' => $artwork,
        ]);
        if (!$cartArtwork) {
            return new JsonResponse(['error' => 'La obra no está asociada al carrito'], 404);
        }

        return new JsonResponse(['isSelected' => $cartArtwork->isSelected()]);
    }

    #[Route('/{cart_id}/cartedselected', name: 'get_cartedselected', methods: ['GET'])]
    public function getCartedSelected(int $cart_id, CartRepository $cartRepository): JsonResponse
    {
        $cart = $cartRepository->find(id: $cart_id);

        if (!$cart) {
            return new JsonResponse(['error' => 'Cart not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = $cart->getCartArtworksSelected();

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }



    #[Route('/create-payment-intent', name: 'create_payment_intent', methods: ['POST'])]
    public function createPaymentIntent(Request $request): JsonResponse
    {
        // Obtener los datos de la solicitud (el cuerpo del POST)
        $paymentData = json_decode($request->getContent(), true);

        // Validar los datos (si es necesario)
        $amount = $paymentData['amount'] ?? null;
        $currency = $paymentData['currency'] ?? null;

        if (!$amount || !$currency) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }

        try {

            // Crear el PaymentIntent con Stripe
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount, // La cantidad debe estar en la unidad mínima de la moneda (ejemplo: centavos en USD)
                'currency' => $currency,
            ]);

            // Obtener el client_secret del PaymentIntent
            $clientSecret = $paymentIntent->client_secret;
            $paymentIntentId = $paymentIntent->id; // Guardamos el ID del PaymentIntent

            // Responder con el client_secret
            return new JsonResponse([
                'client_secret' => $clientSecret,
                'payment_intent_id' => $paymentIntentId, // Enviamos también el ID
            ]);
        } catch (\Exception $e) {
            // Si ocurre un error al crear el PaymentIntent, devolver un error
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    #[Route('/cancel-payment-intent', name: 'cancel_payment_intent', methods: ['POST'])]
    public function cancelPaymentIntent(Request $request): JsonResponse
    {
        // Obtener el client_secret de la solicitud
        $paymentData = json_decode($request->getContent(), true);
        $paymentIntentId = $paymentData['payment_intent_id'] ?? null;

        if (!$paymentIntentId) {
            return new JsonResponse(['error' => 'Missing required payment_intent_id'], 400);
        }

        try {
            // Recuperar el PaymentIntent usando su ID
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            // Cancelar el PaymentIntent
            $paymentIntent->cancel();

            // Responder con el estado del PaymentIntent cancelado
            return new JsonResponse([
                'payment_intent_id' => $paymentIntentId,
                'status' => $paymentIntent->status // Mostrar el estado del PaymentIntent
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }





    #[Route('/update-amount', name: 'update-amount', methods: ['POST'])]
    public function updateAmount(Request $request, CartRepository $cartRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validar existencia de datos y tipos correctos
        if (
            !isset($data['cart_id'], $data['total_amount']) ||
            !is_numeric($data['cart_id']) ||
            !is_numeric($data['total_amount']) ||
            $data['total_amount'] < 0
        ) {
            return new JsonResponse(['error' => 'Datos inválidos'], 400);
        }

        $cartId = (int)$data['cart_id'];
        $totalAmount = (float)$data['total_amount'];

        // Buscar el carrito por ID
        $cart = $cartRepository->find($cartId);

        if (!$cart) {
            return new JsonResponse(['error' => 'Carrito no encontrado'], 404);
        }
        // Actualizar el monto total del carrito
        $cart->setTotalAmount($totalAmount);
        $entityManager->persist($cart);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'El monto total del carrito se ha actualizadsadasdasdo',
            'cart_id' => $cart->getId(),
            'total_amount' => $totalAmount
        ], 200);
    }


    #[Route('/{id}/total', name: 'get_total', methods: ['GET'])]
    public function getTotalAmount(int $id, CartRepository $cartRepository): JsonResponse
    {
        $cart = $cartRepository->find(id: $id);
        $data = $cart->getTotalAmount();
        return new JsonResponse($data);
    }
}
