<?php

declare(strict_types=1);

namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{
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
