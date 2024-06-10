<?php

namespace App\Controller;

use App\Entity\Page;
use App\Form\PageType;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


use Symfony\Component\String\Slugger\SluggerInterface;
#[Route('/page')]
class PageController extends AbstractController
{

    #[Route('/{id}', name: 'page_index', methods: ['GET'])]
    public function getPage(PageRepository $pageRepository, string $id): JsonResponse
    {
        $page = $pageRepository->find($id);
        $data = "";
        if ($page) {
            $data = $page->getPage();            
        }
        return new JsonResponse($data);
    }

    #[Route('/{id}/img', name: 'page_index_img', methods: ['GET'])]
    public function getPageImg(PageRepository $pageRepository, string $id)
    {
        $page = $pageRepository->find($id);

        $imagePath = 'uploads/pages/'.$page->getName().'/'.$page->getImage();


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
