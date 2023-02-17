<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Form\DogType;
use App\Helper\Slugify;
use App\Manager\AnimalManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/dogs')]
class DogController extends AbstractController
{
    private AnimalManager $dogManager;
    private Slugify $slugger;
    private PaginatorInterface $paginator;

    public function __construct(AnimalManager $dogManager, Slugify $slugger, PaginatorInterface $paginator)
    {
        $this->dogManager = $dogManager;
        $this->slugger = $slugger;
        $this->paginator = $paginator;
    }

    #[Route('/', name: 'admin_dog', methods: ['GET', 'POST'])]
    public function index(Request $request)
    {
        $filterName = $request->get('name') ?? null;
        $filterBreed = $request->get('breed') ?? null;
        //TODO: crear un metodo en el repo para buscar por nombre con LIKE
        $criteria = $filterName ? ['name' => $filterName] : [];
        $data = $this->dogManager->findBy($criteria, ['dateAdd' => 'DESC']);
        $dogs = $this->paginator->paginate($data, $request->query->getInt('page', 1), 10);

        return $this->render('admin/dog/index.html.twig', [
            'dogs' => $dogs,
            'filterName' => $filterName,
        ]);
    }

    #[Route('/nuevo', name: 'admin_dog_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $dog = new Animal();
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
            $this->addFlash('success','El cliente se ha creado correctamente');

            return $this->redirectToRoute('admin_dog');
        }

        return $this->render('admin/dog/new.html.twig', [
            'form' => $form,
            'dog' => $dog,
        ]);
    }

    #[Route('/editar/{id}', name: 'admin_dog_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Animal $dog): Response
    {
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

        return $this->render('admin/dog/edit.html.twig', [
            'form' => $form,
            'dog' => $dog
        ]);
    }

    #[Route('/ver/{id}', name: 'admin_dog_show', methods: ['GET'])]
    public function show(Animal $dog): Response
    {
        return $this->render('admin/dog/show.html.twig', [
            'dog' => $dog,
        ]);
    }

    #[Route('/{id}', name: 'admin_dog_delete', methods: ['POST'])]
    public function delete(Request $request, Animal $dog): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dog->getId(), $request->request->get('_token'))) {
            //        TODO: comprobar si el cliente tiene relaciones

            $this->dogManager->delete($dog);
            $this->addFlash('success','El cliente se ha eliminado correctamente');
        }

        return $this->redirectToRoute('admin_dog');
    }
}