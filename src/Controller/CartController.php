<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\WorkRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\ArtworkRepository;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    #[Route('/cart/addArtwork', name: 'app_cart_add', methods: ['POST'])]
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


        $cart->addArtwork($artwork);
        $entityManager->persist($cart);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Se ha añadido la obra al carrito',
            'cart_id' => $cart->getId(),
            'artwork_id' => $artwork->getId()
        ], 200);
    }
}
