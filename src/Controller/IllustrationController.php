<?php

namespace App\Controller;


use App\Repository\IllustrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


#[Route('/illustration')]
class IllustrationController extends AbstractController
{
    #[Route('/', name: 'illustrations', methods: ['GET'])]
    public function getAllIllustrations(IllustrationRepository $illustrationRepository): JsonResponse
    {
        $illustrations = $illustrationRepository->findAll();
    
        $data = [];
        foreach ($illustrations as $illustration) {
            $data[] = $illustration->getIllustration();
        }

        return new JsonResponse($data);
    }

    // Coge los datos de una ilustracion
    #[Route('/{id}', name: 'illustration_detail', methods: ['GET'])]
    public function getIllustrationDetails(string $id, IllustrationRepository $illustrationRepository): JsonResponse
    {
        $illustration = $illustrationRepository->find($id);
        $data = $illustration->getIllustration();
        return new JsonResponse($data);
    }

    #[Route('/{id}/img', name: 'illustration_index_img', methods: ['GET'])]
    public function getIllustrationImg(IllustrationRepository $illustrationRepository, string $id)
    {
        $illustration = $illustrationRepository->find($id);

        $imagePath = 'uploads/shop/'.$illustration->getCollection().'/'.$illustration->getId().'/'.$illustration->getImage();


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
