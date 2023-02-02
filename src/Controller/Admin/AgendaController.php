<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgendaController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route('/admin/agenda', name: 'admin_agenda', methods: 'GET')]
    public function index(Request $request): Response
    {
        return $this->render('admin/agenda/index.html.twig', []);
    }
}