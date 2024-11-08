<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Token;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;



#[Route('/user')]
class UserController extends AbstractController
{
     /**
     * @Route("/user/current-user", name="current_user", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function getCurrentUser(UserRepository $userRepository): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }
        $usermodel = $userRepository->find(id: $user->getUserIdentifier());
        return new JsonResponse([
            'id' => $usermodel->getId(),
            'email' => $usermodel->getEmail(),
            'name' => $usermodel->getName(),
        ]);
    }

    #[Route('/{id}', name: 'user', methods: ['GET'])]
    public function getUserById(int $id, UserRepository $userRepository): JsonResponse {
        $user = $userRepository->find(id: $id);
        $data[] = $user->getUser();
        return new JsonResponse($data);
    }

    #[Route('/login', name: 'user_login', methods: ['POST'])]
    public function login(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $hasher, JWTTokenManagerInterface $jwtTokenManager, EntityManagerInterface $entityManager, SessionInterface $session): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // Validar datos de entrada
        if (!isset($data['email']) || !isset($data['pwd'])) {
            return new JsonResponse('Missing email or password', JsonResponse::HTTP_BAD_REQUEST);
        }
        $email = $data['email'];
        $password = $data['pwd'];
        // Buscar usuario por correo electrónico
        $user = $userRepository->findOneByEmail($email); 

        if (!$user) {
            return new JsonResponse('User not found', JsonResponse::HTTP_NOT_FOUND);
        }
        // Validar la contraseña
        if (!$hasher->isPasswordValid($user, $password)) {
            return new JsonResponse('Invalid credentials', JsonResponse::HTTP_UNAUTHORIZED);
        }
        // Crear token JWT
        $token = $jwtTokenManager->create($user);

        // Configurar datos de sesión
        $session->set('user_id', $user->getId());
        $session->set('user_token', $token);
        
        $user->setToken($token);
        $user->setValidT(true);
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['token' => $user->getToken(), 'user' => $user->getUserSafe()]);
        return new JsonResponse(['token' => $token, 'user' => $user->getUser()]);
    }

    #[Route('/login-token', name: 'user_login_token', methods: ['POST'])]
public function loginByToken(Request $request, UserRepository $userRepository, LoggerInterface $loggerInterface): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    // Validate incoming data
    if (!isset($data['token'])) {
        return new JsonResponse(['error' => 'Missing token'], JsonResponse::HTTP_BAD_REQUEST);
    }

    $token = $data['token'];

    // Find the user by token
    $user = $userRepository->findOneByToken($token);

    if (!$user) {
        return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
    }

    // Validate token expiration or session status
    $isValid = $user->isValidT(); 

    if (!$isValid) {
        return new JsonResponse(['error' => 'Session ended'], JsonResponse::HTTP_UNAUTHORIZED);
    }

    // If everything is fine, return user data and token
    return new JsonResponse([
        'token' => $token,
        'user' => $user->getUserSafe()
    ]);
}


    // #[Route('/login-session', name: 'user_login_session', methods: ['POST'])]
    // public function loginSession(SessionInterface $session, UserRepository $userRepository): JsonResponse {
    //     $userId = $session->get('user_id');
    //     $token = $session->get('user_token');

    //     if (!$userId) {
    //         return new JsonResponse('User not authenticated', JsonResponse::HTTP_UNAUTHORIZED);
    //     }
    //     if (!$token) {
    //         return new JsonResponse('Session ended', JsonResponse::HTTP_UNAUTHORIZED);
    //     }

    //     $user = $userRepository->find($userId);

    //     return new JsonResponse(['token' => $token, 'user' => $user->getUserSafe()]);
    // }

    #[Route('/new', name: 'user_new', methods: ['POST'])]
    public function createUser(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = $request->getPayload();

        $user = new User();
        $user->setEmail($data->get('email'));
        $user->setName($data->get('name'));
        $user->setSurname($data->get('surname'));
        $user->setNick($data->get('nick'));
        $user->setPhone($data->get('phone'));

        $plaintextPassword = $data->get('pwd');
        $hashedPwd = $passwordHasher->hashPassword($user, $plaintextPassword);
        $user->setPassword($hashedPwd);

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['status' => 'User created!'], JsonResponse::HTTP_CREATED);
    }



    // ------------------------------ //
    // ----------ADMIN ZONE---------- //
    // ------------------------------ //
    

    #[Route('/admin/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
