<?php

namespace App\Controller;

use App\Repository\MaterialsRepository;
use App\Repository\PieceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

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
                'artwork_id' => $piece->getArtwork()->getId(),
                'title' => $piece->getTitle(),
                'materials' => $piece->getMaterialsName(),
                'width' => $piece->getWidth(),
                'height' => $piece->getHeight(),
                'depth' => $piece->getDepth(),
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

        $data[] = [
            'id' => $piece->getId(),
            'artwork_id' => $piece->getArtwork()->getId(),
            'title' => $piece->getTitle(),
            'materials' => $piece->getMaterialsName(),
            'width' => $piece->getWidth(),
            'height' => $piece->getHeight(),
            'depth' => $piece->getDepth(),
            'images' => $piece->getImages(),
        ];

        return new JsonResponse($data);
    }

    #[Route('/{id}/{img}', name: 'piece_img', methods: ['GET'])]
    public function getPieceImg(PieceRepository $pieceRepository, string $id, string $img)
    {
        $piece = $pieceRepository->find($id);
        $artwork = $piece->getArtwork()->getId();
        $work = $piece->getArtwork()->getWork()->getId();

        $imagePath = 'uploads/works/'.$work.'/'.$artwork.'/'.$piece->getId().'/'.$img;


        if (!file_exists($imagePath)) {
            throw $this->createNotFoundException('Image not found');
        }

        $imageContent = file_get_contents($imagePath);
        $mimeType = mime_content_type($imagePath);

        $response = new Response($imageContent);
        $response->headers->set('Content-Type', $mimeType);

        return $response;
    }


    #[Route('/{id}/addm', name: 'piece_addm', methods: ['GET', 'POST'])]
    public function addM(PieceRepository $pieceRepository, string $id, Request $request, MaterialsRepository $materialsRepository, EntityManagerInterface $entityManager)
    {
        $piece = $pieceRepository->find($id);
        $data = json_decode($request->getContent(), true);
        $selectedM = $data['selectedM'] ?? [];

        if ($selectedM) {
            foreach ($selectedM as $name) {
                $material = $materialsRepository->findOneBy(['Name'=>$name]);
                $piece->addMaterial($material);
                $entityManager->persist($piece);
            }

            // Guardar todos los cambios en la base de datos
            $entityManager->flush();

            // Respuesta de éxito
            return new JsonResponse(['status' => 'success', 'message' => 'Materiales añadidos correctamente.']);
        }
    }



}
