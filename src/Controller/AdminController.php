<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard', methods: 'GET')]
    public function dashboard(Request $request): Response
    {;
        return $this->render('admin/dashboard.html.twig');
    }

    #[Route('/admin/test', name: 'admin_test', methods: 'GET')]
    public function test(Request $request): Response
    {;
        dump('test-route');die;

//        return $this->render('admin/dashboard.html.twig');
    }
}