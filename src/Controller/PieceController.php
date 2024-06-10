<?php

namespace App\Controller;

use App\Entity\Piece;
use App\Form\PieceType;
use App\Repository\PieceRepository;
use App\Repository\WorkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


#[Route('/piece')]
class PieceController extends AbstractController
{

    #[Route('/', name: 'piece_index', methods: ['GET'])]
    public function getAllPieces(PieceRepository $pieceRepository): JsonResponse
    {
        $pieces = $pieceRepository->findAll();
    
        $data = [];
        foreach ($pieces as $piece) {
            $data[] = [
                'id' => $piece->getId(),
                'work_id' => $piece->getWork()->getId(),
                'title' => $piece->getTitle(),
                'creation_date' => $piece->getCreationYear(),
                'materials' => $piece->getMaterials(),
                'width' => $piece->getWidth(),
                'height' => $piece->getHeight(),
                'depth' => $piece->getDepht(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/{id}', name: 'piece_detail', methods: ['GET'])]
    public function getPieceDetails(int $id, PieceRepository $pieceRepository): JsonResponse
    {
        $piece = $pieceRepository->find($id);
        
        if (!$piece) {
            return new JsonResponse(['error' => 'Piece not found'], 404);
        }

        $images = [];
        foreach ($piece->getImages() as $image) {
            $images[] = $image->getImage();
        }

        $data[] = [
            'id' => $piece->getId(),
            'work_id' => $piece->getWork()->getId(),
            'title' => $piece->getTitle(),
            'creation_date' => $piece->getCreationYear(),
            'materials' => $piece->getMaterials(),
            'width' => $piece->getWidth(),
            'height' => $piece->getHeight(),
            'depth' => $piece->getDepht(),
            'images' => $images
        ];

        return new JsonResponse($data);
    }

    #[Route('/{id}/{img}', name: 'piece_img', methods: ['GET'])]
    public function getPieceImg(PieceRepository $pieceRepository, string $id, string $img)
    {
        $piece = $pieceRepository->find($id);
        $work = $piece->getWork();

        $imagePath = 'uploads/works/'.$work->getId().'/'.$piece->getId().'/'.$img;


        if (!file_exists($imagePath)) {
            throw $this->createNotFoundException('Image not found');
        }

        $imageContent = file_get_contents($imagePath);
        $mimeType = mime_content_type($imagePath);

        $response = new Response($imageContent);
        $response->headers->set('Content-Type', $mimeType);

        return $response;
    }
}
