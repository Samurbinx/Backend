<?php

namespace App\Controller;

use App\Entity\Piece;
use App\Entity\Work;
use App\Entity\Page;
use App\Entity\Image;

use App\Form\WorkType;
use App\Form\PageType;
use App\Form\PieceType;
use App\Repository\IllustrationRepository;
use App\Repository\PageRepository;
use App\Repository\PieceRepository;
use App\Repository\UserRepository;
use App\Repository\WorkRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/aesma')]
class AdminZoneController extends AbstractController
{
    #[Route('', name: 'app_aesma_index', methods: ['GET'])]
    public function index(PageRepository $pageRepository): Response
    {
        $page = $pageRepository->find(1);
        return $this->render('page/show.html.twig', [
            'page' => $page,
        ]);

        // return $this->render('base.html.twig');

    }

    

    // --------- PROYECTOS ---------- //
    #[Route('/work', name: 'app_work_index', methods: ['GET'])]
    public function work(WorkRepository $workRepository): Response
    {
        return $this->render('work/index.html.twig', [
            'works' => $workRepository->findAll(),
        ]);
    }

    #[Route('/work/new', name: 'app_work_new', methods: ['GET', 'POST'])]
    public function newWork(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $work = new Work();
        $form = $this->createForm(WorkType::class, $work);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $pageImage = $form->get('Image')->getData();

            if ($pageImage) {
                // Ensure the work entity is persisted to generate an ID before creating the directory
                $entityManager->persist($work);
                $entityManager->flush();

                $originalFilename = $work->getAssetsRoute() . '-portada';

                // safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pageImage->guessExtension();

                $assetsDirectory = 'uploads/works/' . $work->getId() . '/';

                // Ensure the uploads directory exists
                if (!is_dir($assetsDirectory)) {
                    mkdir($assetsDirectory, 0777, true);
                }

                try {
                    $pageImage->move($assetsDirectory, $newFilename);
                } catch (FileException $e) {
                    // Log error and provide feedback
                    $this->addFlash('error', 'File upload failed: ' . $e->getMessage());
                    return $this->redirectToRoute('app_page_edit', ['id' => $work->getId()]);
                }
                $work->setImage($newFilename);
            }

            $entityManager->persist($work);
            $entityManager->flush();

            return $this->redirectToRoute('app_work_show', ['id' => $work->getId()], Response::HTTP_SEE_OTHER);

        }

        return $this->render('work/new.html.twig', [
            'work' => $work,
            'form' => $form,
        ]);
    }

    #[Route('/work/{id}', name: 'app_work_show', methods: ['GET'])]
    public function showWork(Work $work): Response
    {
        return $this->render('work/show.html.twig', [
            'work' => $work,
        ]);
    }

    #[Route('/work/{id}/edit', name: 'app_work_edit', methods: ['GET', 'POST'])]
    public function editWork(Request $request, Work $work, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WorkType::class, $work);
        $form->handleRequest($request);

        $assetsDirectory = 'uploads/works/' . $work->getId() . '/';

        if ($form->isSubmitted() && $form->isValid()) {
            $pageImage = $form->get('Image')->getData();

            if ($pageImage) {
                $originalFilename = $work->getAssetsRoute() . '-portada';
                // safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pageImage->guessExtension();

                // Ensure the uploads directory exists
                if (!is_dir($assetsDirectory)) {
                    mkdir($assetsDirectory, 0777, true);
                }

                // Delete the previous image if exists
                $currentImage = $work->getImage();
                if ($currentImage && file_exists($assetsDirectory . $currentImage)) {
                    unlink($assetsDirectory . $currentImage);
                }

                try {
                    $pageImage->move($assetsDirectory, $newFilename);
                } catch (FileException $e) {
                    // Log error and provide feedback
                    $this->addFlash('error', 'File upload failed: ' . $e->getMessage());
                    return $this->redirectToRoute('app_page_edit', ['id' => $work->getId()]);
                }
                $work->setImage($newFilename);
            }

            $entityManager->persist($work);
            $entityManager->flush();

            return $this->redirectToRoute('app_work_show', ['id' => $work->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('work/edit.html.twig', [
            'work' => $work,
            'form' => $form,
        ]);
    }


    #[Route('/work/{id}', name: 'app_work_delete', methods: ['POST'])]
    public function deleteWork(Request $request, Work $work, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $work->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->beginTransaction();

            try {
                $pieces = $work->getPieces();

                foreach ($pieces as $piece) {
                    $entityManager->remove($piece);
                }

                // Flush the changes before removing the directory to avoid integrity constraint violation
                $entityManager->flush();

                $assetsDirectory = 'uploads/works/' . $work->getId() . '/';
                if (is_dir($assetsDirectory)) {
                    $files = scandir($assetsDirectory);
                    foreach ($files as $file) {
                        if ($file === '.' || $file === '..') {
                            continue;
                        }

                        $path = $assetsDirectory . '/' . $file;
                        if (is_dir($path)) {
                            $this->deleteDirectory($path);
                        } else {
                            unlink($path);
                        }
                    }

                    // Delete all files and directories recursively inside the assets directory
                    $this->deleteDirectory($assetsDirectory);
                }
                    $entityManager->remove($work);
                    $entityManager->flush();

                    $entityManager->commit();
                
            } catch (\Exception $e) {
                // Rollback changes if an exception occurs
                $entityManager->rollback();
                throw $e;
            }
        }

        return $this->redirectToRoute('app_work_index', [], Response::HTTP_SEE_OTHER);
    }

    // Function to delete directory and its content recursively
    private function deleteDirectory($directory)
    {
        if (!is_dir($directory)) {
            return;
        }

        $files = scandir($directory);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $path = $directory . '/' . $file;
            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }

        rmdir($directory);
    }


    // --------- PIECES ---------- //
    #[Route('/piece', name: 'app_piece_index', methods: ['GET'])]
    public function piece(PieceRepository $pieceRepository): Response
    {
        return $this->render('piece/index.html.twig', [
            'pieces' => $pieceRepository->findAll(),
        ]);
    }

    #[Route('/piece/{id}', name: 'app_piece_show', methods: ['GET'])]
    public function showPiece(Piece $piece, PieceRepository $pieceRepository, PieceController $controller, string $id): Response
    {
        $piece = $pieceRepository->find($id);

        return $this->render('piece/show.html.twig', [
            'piece' => $piece,
        ]);
    }

    // #[Route('/piece/{id}/edit', name: 'app_piece_edit', methods: ['GET', 'POST'])]
    // public function editPiece(Request $request, Piece $piece, EntityManagerInterface $entityManager, PieceRepository $pieceRepository, string $id): Response
    // {
    //     $piece = $pieceRepository->find($id);
    //     $work = $piece->getWork();

    //     $route = $work->getId() . '/' . $id . '/';
    //     $assetsDirectory = 'uploads/works/' . $route;

    //     $form = $this->createForm(PieceType::class, $piece);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // Handle file uploads
    //         $imageFiles = $form->get('Images')->getData();

    //         if ($imageFiles) {
    //             foreach ($imageFiles as $imageFile) {
    //                 $newFilename = uniqid() . '.' . $imageFile->guessExtension();

    //                 // Move the file to the directory where images are stored
    //                 try {
    //                     $imageFile->move(
    //                         $assetsDirectory,
    //                         $newFilename
    //                     );
    //                 } catch (FileException $e) {
    //                     // Handle exception
    //                 }

    //                 // Update the images array
    //                 $piece->addImage($newFilename);
    //             }
    //         }

    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_piece_show',  ['id' => $id], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('piece/edit.html.twig', [
    //         'piece' => $piece,
    //         'form' => $form,
    //     ]);
    // }

    

    
    #[Route('/piece/{id}/edit', name: 'app_piece_edit', methods: ['GET', 'POST'])]
    public function editPiece(Request $request, Piece $piece, EntityManagerInterface $entityManager, PieceRepository $pieceRepository, string $id): Response
    {
        $piece = $pieceRepository->find($id);
        $work = $piece->getWork();
    
        $route = $work->getId() . '/' . $id . '/';
        $assetsDirectory = 'uploads/works/' . $route;
    
        $form = $this->createForm(PieceType::class, $piece);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file uploads
            $imageFiles = $form->get('Images')->getData();
    
            if ($imageFiles) {
                foreach ($imageFiles as $imageFile) {
                    $newFilename = uniqid() . '.' . $imageFile->guessExtension();
    
                    // Move the file to the directory where images are stored
                    try {
                        $imageFile->move(
                            $assetsDirectory,
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // Handle exception
                    }
    
                    // Update the images array
                    $piece->addImage($newFilename);
                }
            }
            // Handle image deletions
            $deleteImages = json_decode($request->request->get('delete_images', '[]'), true);
    
            foreach ($deleteImages as $image) {
                $imagePath = $assetsDirectory . $image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                    $piece->deleteImage($image);
                }
            }
            $entityManager->flush();
            return $this->redirectToRoute('app_piece_show',  ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        return $this->render('piece/edit.html.twig', [
            'piece' => $piece,
            'form' => $form,
        ]);
    }
    

    #[Route('/piece/{id}', name: 'app_piece_delete', methods: ['POST'])]
    public function deletePiece(Request $request, Piece $piece, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $piece->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->beginTransaction();

            try {
                // Delete the associated directory and its contents
                $assetsDirectory = 'uploads/works/' . $piece->getWork()->getId() . '/';
                $pieceDirectory = $assetsDirectory . '/' . $piece->getId() . '/';

                $this->deleteDirectory($pieceDirectory);

                $entityManager->remove($piece);
                $entityManager->flush();

                $entityManager->commit();
            } catch (\Exception $e) {
                // Rollback changes if an exception occurs
                $entityManager->rollback();
                throw $e;
            }
        }

        return $this->redirectToRoute('app_work_show', ['id' => $piece->getWork()->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/work/{id}/piece/new', name: 'app_piece_new', methods: ['GET', 'POST'])]
    public function newPiece(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, string $id, WorkRepository $workRepository): Response
    {
        $piece = new Piece();
        $form = $this->createForm(PieceType::class, $piece);

        $form->handleRequest($request);

        $work = $workRepository->find($id);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $piece->setWork($work);
            $entityManager->persist($piece);
            $entityManager->flush();

            $route = $id . '/' . $piece->getId() . '/';
            $assetsDirectory = 'uploads/works/' . $route;

            $images = $form->get('Images')->getData();
            $imagePaths = [];

            foreach ($images as $image) {
                $newFilename = uniqid() . '.' . $image->guessExtension();

                // Ensure the uploads directory exists
                if (!is_dir($assetsDirectory)) {
                    mkdir($assetsDirectory, 0777, true);
                }

                try {
                    $image->move(
                        $assetsDirectory,
                        $newFilename
                    );
                    $imagePaths[] = $newFilename;
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                }
            }

            $piece->setImages($imagePaths);

            $entityManager->persist($piece);
            $entityManager->flush();

            return $this->redirectToRoute('app_work_show', ['id' => $id]);
        }

        return $this->render('piece/new.html.twig', [
            'piece' => $piece,
            'form' => $form->createView(),
            'work' => $work
        ]);
    }

    #[Route('/piece/{id}/{img}', name: 'app_piece_delete_image', methods: ['POST'])]
    public function deletePieceImage(Request $request, Piece $piece, EntityManagerInterface $entityManager, string $img, PieceRepository $pieceRepository, string $id): Response
    {
        $piece = $pieceRepository->find($id);

        // Remove the image from the piece's images array
        $images = $piece->getImages();
        $index = array_search($img, $images);
        if ($index !== false) {
            unset($images[$index]);
            $piece->setImages($images);

            // Delete the image file from the server
            $imagePath = 'uploads/works/' . $piece->getWork()->getTitle() . '/' . $piece->getTitle() . '/' . $img;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $entityManager->flush();
        }

        // Redirect back to the piece edit page
        return $this->redirectToRoute('app_piece_edit', ['id' => $id]);
    }

    // --------- PAGES ---------- //
    #[Route('/page/{id}', name: 'app_page_show', methods: ['GET'])]
    public function showPage(Page $page, string $id): Response
    {
        return $this->render('page/show.html.twig', [
            'page' => $page,
        ]);
    }

    #[Route('/page/{id}/edit', name: 'app_page_edit', methods: ['GET', 'POST'])]
    public function editPage(Request $request, Page $page, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        $assetsDirectory = 'uploads/pages/' . $page->getName() . '/';

        if ($form->isSubmitted() && $form->isValid()) {
            $pageImage = $form->get('Image')->getData();

            if ($pageImage) {
                $originalFilename = pathinfo($pageImage->getClientOriginalName(), PATHINFO_FILENAME);
                // safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pageImage->guessExtension();

                // Ensure the uploads directory exists
                if (!is_dir($assetsDirectory)) {
                    mkdir($assetsDirectory, 0777, true);
                }

                // Delete the previous image if exists
                $currentImage = $page->getImage();
                if ($currentImage && file_exists($assetsDirectory . $currentImage)) {
                    unlink($assetsDirectory . $currentImage);
                }

                try {
                    $pageImage->move($assetsDirectory, $newFilename);
                } catch (FileException $e) {
                    // Log error and provide feedback
                    $this->addFlash('error', 'File upload failed: ' . $e->getMessage());
                    return $this->redirectToRoute('app_page_edit', ['id' => $page->getId()]);
                }
                $page->setImage($newFilename);
            }

            $entityManager->persist($page);
            $entityManager->flush();

            return $this->redirectToRoute('app_page_show', ['id' => $page->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('page/edit.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }


    // --------- USER ---------- //
    #[Route('/user', name: 'app_user_index', methods: ['GET'])]
    public function user(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/illustration', name: 'app_illustration_index', methods: ['GET'])]
    public function illustration(IllustrationRepository $illustrationRepository): Response
    {
        return $this->render('illustration/index.html.twig', [
            'illustrations' => $illustrationRepository->findAll(),
        ]);
    }
}
