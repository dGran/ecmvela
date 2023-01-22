<?php

namespace App\Controller;

use App\Entity\Dog;
use App\Form\DogType;
use App\Manager\DogManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private DogManager $dogManager;

    public function __construct(DogManager $dogManager)
    {
        $this->dogManager = $dogManager;
    }

    #[Route('/admin', name: 'admin_dashboard', methods: 'GET')]
    public function dashboard(Request $request): Response
    {;
        return $this->render('admin/dashboard.html.twig');
    }

    #[Route('/admin/dogs', name: 'admin_dogs_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $dogs = $this->dogManager->findAll();

        return $this->render('admin/dogs/index.html.twig', [
            'dogs' => $dogs,
        ]);
    }

    #[Route('/admin/dogs/new', name: 'admin_dogs_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $dog = new Dog();
        $form = $this->createForm(DogType::class, $dog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dog = $form->getData();
            $this->dogManager->save($dog);

            return $this->redirectToRoute('admin_dogs_index');
        }

        return $this->render('admin/dogs/new.html.twig', [
            'form' => $form,
        ]);
    }
}