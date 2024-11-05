<?php

namespace App\Controller;

use App\Repository\MaterialsRepository;
use App\Entity\Materials;
use App\Form\MaterialsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    #[Route('/materials/new', name: 'materials_new', methods: ['GET', 'POST'])]
    public function addMaterial(Request $request, EntityManagerInterface $entityManager, MaterialsRepository $materialsRepository): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $temporalM = $data['temporalMaterials'] ?? [];

        if ($temporalM) {
            foreach ($temporalM as $name) {
                $newM = new Materials();
                $newM->setName($name);

                // Persistir cada nuevo material
                $entityManager->persist($newM);
            }

            // Guardar todos los cambios en la base de datos
            $entityManager->flush();

            // Respuesta de éxito
            return new JsonResponse(['status' => 'success', 'message' => 'Materiales añadidos correctamente.']);
        }

        // Respuesta en caso de que no haya materiales
        return new JsonResponse(['status' => 'error', 'message' => 'No se recibieron materiales.'], 400);
    }

 


    

}
