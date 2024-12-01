<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;

// Controlador de los emails enviados desde la página de contacto

#[Route('')]
class ContactController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    #[Route('/contact', name: 'contact', methods: ['POST'])]
    public function index(Request $request, MailerInterface $mailer): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            if (!$data) {
                throw new \Exception('Invalid JSON');
            }
            
            $email = (new Email())
                ->from('samurbinx@gmail.com')
                ->to('samurbinx@gmail.com') // Reemplaza esto con tu dirección de correo
                ->subject('AESMA')
                ->text('De: ' . $data['name'] . ' ' . $data['surname'] . "\n\n" . 'Teléfono: ' . $data['phone'] . "\n\n" . 'Mensaje: ' . $data['desc']);

            $mailer->send($email);

            return new JsonResponse(['status' => 'Correo enviado'], Response::HTTP_OK);
        } catch (\Exception $e) {
            $this->logger->error('Error sending email: ' . $e->getMessage());
            return new JsonResponse(['status' => 'Error', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
