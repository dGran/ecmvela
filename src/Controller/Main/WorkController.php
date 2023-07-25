<?php

declare(strict_types=1);

namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trabajos', name: 'works')]
class WorkController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('main/works/index.html.twig', []);
    }
}
