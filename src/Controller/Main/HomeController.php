<?php

namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', []);
    }

    #[Route('/reserva-de-citas', name: 'appointments')]
    public function appointments(): Response
    {
        return $this->render('main/appointments/index.html.twig', []);
    }

    #[Route('/contacto', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('main/contact/index.html.twig', []);
    }

    #[Route('/trabajos', name: 'works')]
    public function works(): Response
    {
        return $this->render('main/works/index.html.twig', []);
    }

    #[Route('/blog', name: 'blog')]
    public function blog(): Response
    {
        return $this->render('main/blog/index.html.twig', []);
    }

    #[Route('/aviso-legal', name: 'legal_warning')]
    public function legalWarning(): Response
    {
        return $this->render('main/legal/legal-warning.html.twig', []);
    }

    #[Route('/politica-de-privacidad', name: 'privacy_policy')]
    public function privacyPolicy(): Response
    {
        return $this->render('main/legal/privacy-policy.html.twig', []);
    }

    #[Route('/politica-de-cookies', name: 'cookies_policy')]
    public function cookiesPolicy(): Response
    {
        return $this->render('main/legal/cookies-policy.html.twig', []);
    }
}
