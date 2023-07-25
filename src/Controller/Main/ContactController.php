<?php

declare(strict_types=1);

namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contacto', name: 'contact')]
class ContactController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('main/contact/index.html.twig', []);
    }
}
