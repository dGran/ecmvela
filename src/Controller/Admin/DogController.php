<?php

namespace App\Controller\Admin;

use App\Entity\Dog;
use App\Form\DogType;
use App\Helper\Slugify;
use App\Manager\DogManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DogController extends AbstractController
{
    private DogManager $dogManager;
    private Slugify $slugger;

    public function __construct(DogManager $dogManager, Slugify $slugger)
    {
        $this->dogManager = $dogManager;
        $this->slugger = $slugger;
    }

    #[Route('/admin/dogs', name: 'admin_dogs', methods: 'GET')]
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
            $uploadedFile = $form['imageFile']->getData();

            if ($uploadedFile) {
                $uploadedFile = $form['imageFile']->getData();
                $destination = $this->getParameter('kernel.project_dir').'/public/img/dogs';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $this->slugger->slugify($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move($destination,$newFilename);

                $dog->setProfileImg($newFilename);
            }

            $this->dogManager->save($dog);

            return $this->redirectToRoute('admin_dogs');
        }

        return $this->render('admin/dogs/new.html.twig', [
            'form' => $form,
        ]);
    }
}