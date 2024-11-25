<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Cart;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\AddressRepository;
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

use function PHPSTORM_META\map;

#[Route('/address')]
class AddressController extends AbstractController
{

    #[Route('/{user_id}', name: 'get_user_address', methods: ['GET'])]
    public function getAddress(int $user_id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find(id: $user_id);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        $data = $user->getAddressJson();
        return new JsonResponse($data);
    }

    #[Route('/{address_id}/del', name: 'del_address', methods: ['POST'])]
    public function delAddress(int $address_id, AddressRepository $addressRepository, EntityManagerInterface $entityManagerInterface): JsonResponse
    {
        $address = $addressRepository->find(id: $address_id);
        if (!$address) {
            return new JsonResponse(['error' => 'address not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        $entityManagerInterface->remove($address);
        $entityManagerInterface->flush();


        return new JsonResponse([
            'message' => 'Se ha eliminado la dirección',
        ], 200);
    }

    #[Route('/alladdress/{user_id}', name: 'get_user_alladdress', methods: ['GET'])]
    public function getAllAddress(int $user_id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find(id: $user_id);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        $data = [];
        foreach ($user->getAllAddress() as $address) {
            $data[] = $address->getAddress();
        }
        return new JsonResponse($data);
    }

    #[Route('/{user_id}/new', name: 'address_new', methods: ['POST'])]
    public function createAddress(int $user_id, Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $user = $userRepository->find(id: $user_id);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = $request->getPayload();
        
        $address = new Address();

        $address->setUser($user);
        $address->setStreet($data->get('street'));
        $address->setDetails($data->get('details'));
        $address->setZIPCode($data->get('zipcode'));
        $address->setCity($data->get('city'));
        $address->setProvince($data->get('province'));
        $address->setRecipient($data->get('recipient'));
        $address->setPhone($data->get('phone'));

        $errors = $validator->validate($address);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($address);
        $entityManager->flush();

        // $user->setAddress($address);
        // $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['status' => 'address created!'], JsonResponse::HTTP_CREATED);
    }


    #[Route('/setdefault', name: 'set_default_address', methods: ['POST'])]
    public function setDefault(UserRepository $userRepository, AddressRepository $addressRepository, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['user_id'], $data['address_id'])) {
            return new JsonResponse(['error' => 'Datos incompletos'], 400);
        }

        $user = $userRepository->find(id: $data['user_id']);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $address = $addressRepository->find(id: $data['address_id']);
        if (!$address) {
            return new JsonResponse(['error' => 'Address not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        
        $user->setAddress($address);
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse($data);
    }


    #[Route('/{address_id}/edit', name: 'address_edit', methods: ['POST'])]
    public function editAddress(int $address_id, Request $request, EntityManagerInterface $entityManager, AddressRepository $addressRepository, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $address = $addressRepository->find(id: $address_id);
        if (!$address) {
            return new JsonResponse(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = $request->getPayload();

        $address->setStreet($data->get('street'));
        $address->setDetails($data->get('details'));
        $address->setZIPCode($data->get('zipcode'));
        $address->setCity($data->get('city'));
        $address->setProvince($data->get('province'));

        $errors = $validator->validate($address);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($address);
        $entityManager->flush();

        return new JsonResponse(['status' => 'address edited!'], JsonResponse::HTTP_CREATED);
    }
}
