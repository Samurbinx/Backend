<?php

namespace App\Controller;

use App\Entity\Illustration;
use App\Form\IllustrationType;
use App\Repository\IllustrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/new', name: 'app_illustration_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $illustration = new Illustration();
        $form = $this->createForm(IllustrationType::class, $illustration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($illustration);
            $entityManager->flush();

            return $this->redirectToRoute('app_illustration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('illustration/new.html.twig', [
            'illustration' => $illustration,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_illustration_show', methods: ['GET'])]
    public function show(Illustration $illustration): Response
    {
        return $this->render('illustration/show.html.twig', [
            'illustration' => $illustration,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_illustration_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Illustration $illustration, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IllustrationType::class, $illustration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_illustration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('illustration/edit.html.twig', [
            'illustration' => $illustration,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_illustration_delete', methods: ['POST'])]
    public function delete(Request $request, Illustration $illustration, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$illustration->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($illustration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_illustration_index', [], Response::HTTP_SEE_OTHER);
    }
}
