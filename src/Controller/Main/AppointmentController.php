<?php

namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reserva-de-citas', name: 'appointments')]
class AppointmentController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('main/appointments/index.html.twig', []);
    }
}
