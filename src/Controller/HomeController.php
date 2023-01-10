<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', []);
    }

    #[Route('/citas', name: 'appointments')]
    public function appointments(): Response
    {
        return $this->render('home/appointments/index.html.twig', []);
    }

    #[Route('/contacto', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('home/contact/index.html.twig', []);
    }

    #[Route('/trabajos', name: 'works')]
    public function works(): Response
    {
        return $this->render('home/works/index.html.twig', []);
    }

    #[Route('/aviso-legal', name: 'legal_warning')]
    public function legalWarning(): Response
    {
        return $this->render('home/legal/legal-warning.html.twig', []);
    }

    #[Route('/politica-de-privacidad', name: 'privacy_policy')]
    public function privacyPolicy(): Response
    {
        return $this->render('home/legal/privacy-policy.html.twig', []);
    }

    #[Route('/politica-de-cookies', name: 'cookies_policy')]
    public function cookiesPolicy(): Response
    {
        return $this->render('home/legal/cookies-policy.html.twig', []);
    }
}
