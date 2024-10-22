<?php

namespace App\Controller;

use App\Repository\ArtworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/artwork')]
class ArtworkController extends AbstractController
{

    #[Route('/', name: 'artwork_index', methods: ['GET'])]
    public function getAllArtworks(ArtworkRepository $artworkRepository): JsonResponse
    {
        $artworks = $artworkRepository->findAll();
    
        $data = [];
        foreach ($artworks as $artwork) {
            $data[] = [
                'id' => $artwork->getId(),
                'work_id' => $artwork->getWork()->getId(),
                'title' => $artwork->getTitle(),
                'creation_date' => $artwork->getCreationYear(),
                'price' => $artwork->getPrice(),
                'sold' => $artwork->isSold(),
                'display' => $artwork->getDisplay(),
            ];
        }
        return new JsonResponse($data);
    }

    #[Route('/{id}', name: 'artwork_detail', methods: ['GET'])]
    public function getArtworkDetails(int $id, ArtworkRepository $artworkRepository): JsonResponse
    {
        $artwork = $artworkRepository->find($id);
        $data = $artwork->getArtworkDetail();
        return new JsonResponse($data);
    }

    
}
