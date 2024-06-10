<?php

namespace App\Controller;

use App\Entity\Work;
use App\Form\WorkType;
use App\Repository\WorkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\PieceRepository;
use App\Controller\PieceController;


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

    #[Route('/{id}/img', name: 'work_index_img', methods: ['GET'])]
    public function getPageImg(WorkRepository $workRepository, string $id)
    {
        $work = $workRepository->find($id);

        $imagePath = 'uploads/works/'.$work->getId().'/'.$work->getImage();


        if (!file_exists($imagePath)) {
            throw $this->createNotFoundException('Image not found');
        }

        $imageContent = file_get_contents($imagePath);
        $mimeType = mime_content_type($imagePath);

        $response = new Response($imageContent);
        $response->headers->set('Content-Type', $mimeType);

        return $response;
    }
    
    // Coge los datos del proyecto, sus obras, y todas las imágenes de cada obra
    #[Route('/{id}', name: 'work_detail', methods: ['GET'])]
    public function getWorkDetails(string $id, WorkRepository $workRepository): JsonResponse
    {
        $work = $workRepository->find($id);
        $data = $work->getWorkDetail();
        return new JsonResponse($data);
    }



    // ------------------------------ //
    // ----------ADMIN ZONE---------- //
    // ------------------------------ //

}
