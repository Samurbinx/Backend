<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
use App\Repository\OrderRepository;
use App\Entity\Order;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\Collection;


#[Route('/order')]
class OrderController extends AbstractController
{
    #[Route('/new', name: 'app_order_new', methods: ['POST'])]
    public function newOrder(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, ArtworkRepository $artworkRepository, CartRepository $cartRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['user_id'], $data['artworks'], $data['total_amount'], $data['cart_id'])) {
            return new JsonResponse(['error' => 'Datos incompletos'], 400);
        }

        $entityManager->beginTransaction();

        try {
            $order = new Order();

            $user = $userRepository->find($data['user_id']);
            if (!$user) {
                return new JsonResponse(['error' => 'Usuario no encontrado'], 404);
            }
            $cart = $cartRepository->find($data['cart_id']);
            if (!$cart) {
                return new JsonResponse(['error' => 'Carrito no encontrado'], 404);
            }

            $total_amount = $data['total_amount'];
            if (!$total_amount) {
                return new JsonResponse(['error' => 'Precio total no encontrado'], 404);
            }

            $order->setUser($user);
            $order->setTotalAmount($total_amount);
            $entityManager->persist($order);

            $artworks = $data['artworks'];
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
                    $entityManager->persist($artwork);
                    $entityManager->flush();
                }

            }


            $entityManager->persist($order);
            $entityManager->flush();

            // $cart->removeCartArtworksSelected();
            $cartArtworks = $cart->getCartArtworks();
            foreach ($cartArtworks as $cartArtwork) {
                if ($cartArtwork->isSelected()) {
                    $entityManager->remove($cartArtwork);
                }
            }
            $entityManager->persist($cart);
            $entityManager->flush();

            $entityManager->commit();
            return new JsonResponse([
                'message' => 'Se ha completado el pedido',
                'order' => $order,
                'artworks' => $order->getArtworks()
            ], 200);
        } catch (\Exception $e) {
            $entityManager->rollback();

            // Retornar el error
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}
