<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\ArtworkRepository;
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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



#[Route('/user')]
class UserController extends AbstractController
{

    #[Route('/{id}', name: 'user', methods: ['GET'])]
    public function getUserById(int $id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find(id: $id);
        $data = $user->getUser();
        return new JsonResponse($data);
    }
    #[Route('/isadmin/{id}', name: 'user_isadmin', methods: ['GET'])]
    public function getisadmin(int $id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find(id: $id);
        $data = $user->isAdmin();
        return new JsonResponse($data);
    }

    #[Route('/safe/{id}', name: 'user_safe', methods: ['GET'])]
    public function getUserSafeById(int $id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find(id: $id);
        $data = $user->getUserSafe();
        return new JsonResponse($data);
    }

    #[Route('/login', name: 'user_login', methods: ['POST'])]
    public function login(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $hasher, JWTTokenManagerInterface $jwtTokenManager, EntityManagerInterface $entityManager, SessionInterface $session): JsonResponse
    {
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

        return new JsonResponse(['token' => $user->getToken(), 'user' => $user->getUserSafe(), 'user_id' => $user->getId()]);
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
            'user' => $user->getUserSafe(),
            'user_id' => $user->getId()
        ]);
    }

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

        $cart = new Cart();
        $cart->setUserId($user);
        $cart->setTotalAmount(0);
        $user->setCart($cart);

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


    #[Route(path: '/update/{user_id}', name: 'user_update', methods: ['POST'])]
    public function updateUser(Request $request, int $user_id, UserRepository $userRepository, EntityManagerInterface $entityManager, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = $request->getPayload();

        $user = $userRepository->find($user_id);
        $user->setEmail($data->get('email'));
        $user->setName($data->get('name'));
        $user->setSurname($data->get('surname'));
        $user->setNick($data->get('nick'));
        $user->setPhone($data->get('phone'));


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

        return new JsonResponse(['status' => 'User updated!'], JsonResponse::HTTP_CREATED);
    }

    #[Route(path: '/updatepwd/{user_id}', name: 'user_update_pwd', methods: ['POST'])]
    public function updatePwd(Request $request, int $user_id, UserPasswordHasherInterface $hasher,  UserRepository $userRepository, EntityManagerInterface $entityManager, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = $request->getPayload();

        if (!isset($data)) {
            return new JsonResponse(['error' => 'Missing data'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = $userRepository->find($user_id);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $currentPWD = $data->get('pwd');
        // Validar la contraseña
        if (!$hasher->isPasswordValid($user, $currentPWD)) {
            return new JsonResponse(['message' => 'La contraseña actual no es correcta'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Encriptar la contraseña
        $newPWD = $data->get('npwd');
        $hashedPwd = $passwordHasher->hashPassword($user, $newPWD);
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

        return new JsonResponse(['status' => 'Password updated!'], JsonResponse::HTTP_CREATED);
    }



    // ------------------------------ //
    // ---------- SHOP ZONE --------- //
    // ------------------------------ //
    #[Route('/{user_id}/favsid', name: 'get_user_favsid', methods: ['GET'])]
    public function getFavsId(int $user_id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find(id: $user_id);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        $data = $user->getFavoritesId();
        return new JsonResponse($data);
    }
    #[Route('/{user_id}/favsart', name: 'get_user_favsart', methods: ['GET'])]
    public function getFavsArt(int $user_id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find(id: $user_id);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        $data = $user->getFavoritesJson();
        return new JsonResponse($data);
    }

    #[Route('/{user_id}/carted', name: 'get_user_carted', methods: ['GET'])]
    public function getCarted(int $user_id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find(id: $user_id);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        $data = $user->getCartJson();
        return new JsonResponse($data);
    }


    #[Route('/{user_id}/cartId', name: 'get_user_cartId', methods: ['GET'])]
    public function getCartId(int $user_id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find(id: $user_id);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        $data = $user->getCart()->getId();
        return new JsonResponse($data);
    }
    #[Route('/{user_id}/cartlength', name: 'get_user_cartlength', methods: ['GET'])]
    public function getCartLength(int $user_id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find(id: $user_id);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        $data = count($user->getCart()->getCartArtworks());
        return new JsonResponse($data);
    }

    #[Route('/{user_id}/orders', name: 'orders', methods: ['GET'])]
    public function getOrders(int $user_id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find(id: $user_id);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        $data = $user->getOrdersJson();
        return new JsonResponse($data);
    }
}
