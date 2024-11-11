<?php

namespace App\Controller;

use App\Repository\WorkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\ArtworkRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

// ESTA CLASE SOLO RECOGE DATOS FORMATO JSON
#[Route('/work')]
class WorkController extends AbstractController
{
    #[Route('/', name: 'work_index', methods: ['GET'])]
    public function getAllWorks(WorkRepository $workRepository): JsonResponse
    {
        $works = $workRepository->findAll();

        $data = [];
        foreach ($works as $work) {
            $data[] = $work->getWork();
        }

        return new JsonResponse($data);
    }

    // Coge los datos del proyecto, sus obras, y todas las imágenes de cada obra
    #[Route('/{id}', name: 'work_detail', methods: ['GET'])]
    public function getWorkDetails(string $id, WorkRepository $workRepository): JsonResponse
    {
        $work = $workRepository->find($id);
        $data = $work->getWorkDetail();
        return new JsonResponse($data);
    }

    // #[Route('/title/{id}', name: 'work_detail', methods: ['GET'])]
    // public function getWorkTitle(string $id, WorkRepository $workRepository): JsonResponse
    // {
    //     $work = $workRepository->find($id);
    //     $data = $work->getTitle();
    //     return new JsonResponse($data);
    // }

    #[Route('/{id}/img', name: 'work_index_img', methods: ['GET'])]
    public function getPageImg(WorkRepository $workRepository, string $id)
    {
        $work = $workRepository->find($id);

        $imagePath = 'uploads/works/' . $work->getId() . '/' . $work->getImage();


        if (!file_exists($imagePath)) {
            throw $this->createNotFoundException('Image not found');
        }

        $imageContent = file_get_contents($imagePath);
        $mimeType = mime_content_type($imagePath);

        $response = new Response($imageContent);
        $response->headers->set('Content-Type', $mimeType);

        return $response;
    }

    // ------------------------------ //
    // ----------FAVORITES---------- //
    // ------------------------------ //

    #[Route('/fav', name: 'app_user_fav', methods: ['POST'])]
    public function fav(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, ArtworkRepository $artworkRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['user_id'], $data['artwork_id'])) {
            return new JsonResponse(['error' => 'Datos incompletos'], 400);
        }

        $user = $userRepository->find($data['user_id']);
        $artwork = $artworkRepository->find($data['artwork_id']);
        
        if (!$user || !$artwork) {
            return new JsonResponse(['error' => 'Usuario o obra de arte no encontrado'], 404);
        }

        $shouldAdd = $data['shouldAdd'];
        if ($shouldAdd) {
            $user->addFavorite($artwork);
            $message = 'Obra de arte añadida a favoritos';
        } elseif (!$shouldAdd) {
            $user->removeFavorite($artwork);
            $message = 'Obra de arte eliminada de favoritos';
        } else {
            return new JsonResponse(['error' => 'Invalid action'], 400);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse([
            'message' => $message,
            'user_id' => $user->getId(),
            'artwork_id' => $artwork->getId()
        ], 200);
    }

    
}
