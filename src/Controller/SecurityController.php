<?php

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, PageRepository $pageRepository)
    {

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_aesma_index');
        }

        $image= $pageRepository->find('4')->getImage();
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        if ($error) {
            $error = "Credenciales incorrectas";
        } else {
            if ($this->isGranted('ROLE_USER')) {
                $error = "Acceso denegado - Permisos insuficientes";
            }
        }

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'image' => $image]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout()
    {
        // controller can be blank: it will never be executed!
    }
}
