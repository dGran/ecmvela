<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Dog;
use App\Model\EntityManagerInterface as EntityManagerInterfaceBase;
use App\Repository\DogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class DogManager implements EntityManagerInterfaceBase
{
    private ObjectManager $entityManager;
    private DogRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Dog::class);
    }

    public function findOneById($id): Dog
    {
        /** @var Dog $dog */
        $dog = $this->repository->find($id);

        return $dog;
    }

    public function findOneBy(array $criteria): Dog
    {
        /** @var Dog $dog */
        $dog = $this->repository->findOneBy($criteria);

        return $dog;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria): array
    {
        return $this->repository->findBy($criteria);
    }

    public function create(): Dog
    {
        return new Dog();
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function save($entity): mixed
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    public function delete(Dog $dog): Dog
    {
        $this->entityManager->remove($dog);
        $this->entityManager->flush();

        return $dog;
    }
}