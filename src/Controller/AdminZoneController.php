<?php
namespace App\Controller;
use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Work;
use App\Entity\Artwork;
use App\Entity\Materials;
use App\Entity\Piece;
use App\Entity\Page;

use App\Form\WorkType;
use App\Form\ArtworkType;
use App\Form\PieceType;
use App\Form\MaterialsType;
use App\Form\PageType;

use App\Repository\WorkRepository;
use App\Repository\ArtworkRepository;
use App\Repository\MaterialsRepository;
use App\Repository\PieceRepository;
use App\Repository\PageRepository;
use App\Repository\UserRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Routing\Attribute\Route;

// ESTA CLASE RECOGE TODOS LAS CRUD NECESARIAS PARA LAS TWIG DE LA ZONA DE ADMINISTRACIÓN
// PROYECTOS, OBRAS, PÁGINAS, USUARIOS Y TIENDA
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
                // Elimina recursivamente
                $artworks = $work->getArtworks();

                foreach ($artworks as $artwork) {
                    $pieces = $artwork->getPieces();
                    foreach ($pieces as $piece) {
                        $entityManager->remove($piece);
                    }
                    $entityManager->remove($artwork);
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


    // ---------- ARTWORKS ----------- //
    #[Route('/artwork', name: 'app_artwork_index', methods: ['GET'])]
    public function artwork(ArtworkRepository $artworkRepository): Response
    {
        return $this->render('artwork/index.html.twig', [
            'artwork' => $artworkRepository->findAll()
        ]);
    }

    #[Route('/artwork/{id}', name: 'app_artwork_show', methods: ['GET'])]
    public function showArtwork(ArtworkRepository $artworkRepository, string $id): Response
    {
        $artwork = $artworkRepository->find($id);

        return $this->render('artwork/show.html.twig', [
            'artwork' => $artwork,
        ]);
    }

    #[Route('/artwork/{id}', name: 'app_artwork_delete', methods: ['POST'])]
    public function deleteArtwork(Request $request, Artwork $artwork, EntityManagerInterface $entityManager): Response {

        if ($this->isCsrfTokenValid('delete' . $artwork->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->beginTransaction();

            try {

                $pieces = $artwork->getPieces();

                foreach ($pieces as $piece) {
                    $entityManager->remove($piece);
                }

                $entityManager->flush();

                $assetsDirectory = 'uploads/works/' . $artwork->getWork()->getId() . '/' . $artwork->getId() . '/';
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
                    $entityManager->remove($artwork);
                    $entityManager->flush();

                    $entityManager->commit();

            } catch (\Exception $e) {
                // Rollback changes if an exception occurs
                $entityManager->rollback();
                throw $e;
            }
        }
        return $this->redirectToRoute('app_work_show', ['id' => $artwork->getWork()->getId()], Response::HTTP_SEE_OTHER);

    }


    #[Route('/work/{id}/artwork/new', name: 'app_artwork_new', methods: ['GET', 'POST'])]
    public function newArtwork(Request $request, EntityManagerInterface $entityManager, string $id, WorkRepository $workRepository): Response
    {
        $work = $workRepository->find($id);

        $artwork = new Artwork();
        $form = $this->createForm(ArtworkType::class, $artwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artwork->setWork($work);
            $entityManager->persist($artwork);
            $entityManager->flush();

            return $this->redirectToRoute('app_artwork_show', ['id' => $artwork->getId()], Response::HTTP_SEE_OTHER);
        }



        return $this->render('artwork/new.html.twig', [
            'work' => $work,
            'artwork' => $artwork,
            'form' => $form,
        ]);
    }


    #[Route('/artwork/{id}/edit', name: 'app_artwork_edit', methods: ['GET', 'POST'])]
    public function editArtwork(Request $request, EntityManagerInterface $entityManager, string $id, ArtworkRepository $artworkRepository): Response {

        $artwork = $artworkRepository->find($id);
        $work = $artwork->getWork();
        $form = $this->createForm(ArtworkType::class, $artwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($artwork);
            $entityManager->flush();

            return $this->redirectToRoute('app_artwork_show', ['id' => $artwork->getId()], Response::HTTP_SEE_OTHER);
        }


        return $this->render('artwork/new.html.twig', [
            'work' => $work,
            'artwork' => $artwork,
            'form' => $form,
        ]);
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
    public function showPiece(Piece $piece, PieceRepository $pieceRepository, string $id): Response
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
    public function editPiece(Request $request, Piece $piece, EntityManagerInterface $entityManager, PieceRepository $pieceRepository, string $id, MaterialsRepository $materialsRepository): Response
    {
        $piece = $pieceRepository->find($id);
        $artwork = $piece->getArtwork();
        $materials = $materialsRepository->findAll();

        $route = $artwork->getWork()->getId() . '/' . $artwork->getId() . '/' . $id . '/';
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
            return $this->redirectToRoute('app_artwork_show',  ['id' => $artwork->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('piece/edit.html.twig', [
            'piece' => $piece,
            'artwork' => $artwork,
            'form' => $form,
            'materials' => $materials,
        ]);
    }


    #[Route('/piece/{id}', name: 'app_piece_delete', methods: ['POST'])]
    public function deletePiece(Request $request, Piece $piece, EntityManagerInterface $entityManager, string $id): Response
    {
        if ($this->isCsrfTokenValid('delete' . $piece->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->beginTransaction();

            try {
                // Delete the associated directory and its contents
                $artwork = $piece->getArtwork();
                $assetsDirectory = 'uploads/works/' . $artwork->getWork()->getId() . '/' . $artwork->getId()  . '/' . $id;

                $this->deleteDirectory($assetsDirectory);

                $entityManager->remove($piece);
                $entityManager->flush();

                $entityManager->commit();
            } catch (\Exception $e) {
                // Rollback changes if an exception occurs
                $entityManager->rollback();
                throw $e;
            }
        }

        return $this->redirectToRoute('app_artwork_show', ['id' => $artwork->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/artwork/{id}/piece/new', name: 'app_piece_new', methods: ['GET', 'POST'])]
    public function newPiece(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, string $id, ArtworkRepository $artworkRepository, MaterialsRepository $materialsRepository): Response
    {
        $piece = new Piece();
        $form = $this->createForm(PieceType::class, $piece);

        $form->handleRequest($request);

        $artwork = $artworkRepository->find($id);
        $work = $artwork->getWork();
        $workid = $work->getId();
        $materials = $materialsRepository->findAll();

        usort($materials, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });

        if ($form->isSubmitted() && $form->isValid()) {
            $piece->setArtwork($artwork);

            // Recoge los materiales de la request y los añade a la obra
            $selectedM = $request->request->get('selectedMaterials');
            $selectedMaterials = json_decode($selectedM, true); // true para obtener un array asociativo
            if ($selectedMaterials) {
                foreach ($selectedMaterials as $material) {
                    $newmaterial = $materialsRepository->findOneBy(['Name'=>$material]);
                    $piece->addMaterial($newmaterial);
                }
            }

            $entityManager->persist($piece);
            $entityManager->flush();
            
            $pieceid = $piece->getId();


            // Manejo de imágenes
            $assetsDirectory = 'uploads/works/'. $workid . '/' . $id . '/' . $pieceid . '/';

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
                    $this->addFlash('error', 'Hubo un error al subir la imagen. Por favor, inténtalo de nuevo.');
                }
            }

            $piece->setImages($imagePaths);

            $entityManager->persist($piece);
            $entityManager->flush();

            return $this->redirectToRoute('app_artwork_show', ['id' => $id]);
        }

        return $this->render('piece/new.html.twig', [
            'piece' => $piece,
            'form' => $form->createView(),
            'artwork' => $artwork,
            'work' => $work,
            'materials' => $materials,
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
        return $this->redirectToRoute('app_piece_edit', parameters: ['id' => $id]);
    }

    // ------ MATERIAL --------- //
    // #[Route('/material/new', name: 'app_material_new', methods: ['GET', 'POST'])]
    // public function newMaterial(Request $request, EntityManagerInterface $entityManager, MaterialsRepository $materialsRepository): Response
    // {

    //     $material = new Materials();
    //     $form = $this->createForm(MaterialsType::class, $material);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($material);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_work_index');
    //     }

    //     return $this->render('materials/new.html.twig', [
    //         'form' => $form,
    //     ]);
    // }

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

}