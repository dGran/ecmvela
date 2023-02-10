<?php

namespace App\Controller\Admin;

use App\Entity\Dog;
use App\Form\DogType;
use App\Helper\Slugify;
use App\Manager\DogManager;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/dogs')]
class DogController extends AbstractController
{
    private DogManager $dogManager;
    private Slugify $slugger;

    public function __construct(DogManager $dogManager, Slugify $slugger)
    {
        $this->dogManager = $dogManager;
        $this->slugger = $slugger;
    }

    #[Route('/', name: 'admin_dog', methods: 'GET')]
    public function index(): Response
    {
        return $this->render('admin/dog/index.html.twig', [
            'dogs' => $this->dogManager->findAll(),
        ]);
    }

    #[Route('/nuevo', name: 'admin_dog_new', methods: ['GET', 'POST'])]
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

            return $this->redirectToRoute('admin_dog');
        }

        return $this->render('admin/dog/new.html.twig', [
            'form' => $form,
            'dog' => $dog,
        ]);
    }

    #[Route('/editar/{id}', name: 'admin_dog_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dog $dog): Response
    {
        $form = $this->createForm(DogType::class, $dog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $dog = $form->getData();
//            $uploadedFile = $form['imageFile']->getData();
//
//            if ($uploadedFile) {
//                $uploadedFile = $form['imageFile']->getData();
//                $destination = $this->getParameter('kernel.project_dir').'/public/img/dogs';
//                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
//                $newFilename = $this->slugger->slugify($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
//                $uploadedFile->move($destination,$newFilename);
//
//                $dog->setProfileImg($newFilename);
//            }

            $this->dogManager->save($dog);

            return $this->redirectToRoute('admin_dog');
        }

        return $this->render('admin/dog/edit.html.twig', [
            'form' => $form,
            'dog' => $dog
        ]);
    }

    #[Route('/ver/{id}', name: 'admin_dog_show', methods: ['GET'])]
    public function show(Dog $dog): Response
    {
        return $this->render('admin/dog/show.html.twig', [
            'dog' => $dog,
        ]);
    }

    #[Route('/{id}', name: 'admin_dog_delete', methods: ['POST'])]
    public function delete(Request $request, Dog $dog): Response
    {
//        TODO: comprobar si el cliente tiene relaciones
        if ($this->isCsrfTokenValid('delete'.$dog->getId(), $request->request->get('_token'))) {
            $this->dogManager->delete($dog);
        }

        return $this->redirectToRoute('admin_dog');
    }
}