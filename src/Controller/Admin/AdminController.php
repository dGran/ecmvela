<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/test', name: 'admin_test', methods: 'GET')]
    public function test(Request $request): Response
    {;
        dump('test-route');die;

//        return $this->render('admin/dashboard.html.twig');
    }
}
