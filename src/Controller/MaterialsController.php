<?php

namespace App\Controller;

use App\Repository\MaterialsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MaterialsController extends AbstractController
{
    #[Route('/materials', name: 'app_materials', methods: ['GET'])]
    public function getAllMaterials(MaterialsRepository $materialsRepository): JsonResponse
    {
        $materials = $materialsRepository->findAll();
        $data = [];

        foreach ($materials as $material){
            $data[] = [
             'name' => $material->getName()   
            ];
        }
        return new JsonResponse($data);
    }

}
