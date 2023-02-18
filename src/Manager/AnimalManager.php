<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Pet;
use App\Model\EntityManagerInterface as EntityManagerInterfaceBase;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class AnimalManager implements EntityManagerInterfaceBase
{
    private ObjectManager $entityManager;
    private CustomerRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Pet::class);
    }

    public function findOneById($id): Pet
    {
        /** @var Pet $animal */
        $animal = $this->repository->find($id);

        return $animal;
    }

    public function findOneBy(array $criteria): Pet
    {
        /** @var Pet $animal */
        $animal = $this->repository->findOneBy($criteria);

        return $animal;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria): array
    {
        return $this->repository->findBy($criteria);
    }

    public function create(): Pet
    {
        return new Pet();
    }

    /**
     * @param $animal
     * @return mixed
     */
    public function save($animal): mixed
    {
        $this->entityManager->persist($animal);
        $this->entityManager->flush();

        return $animal;
    }

    public function delete(Pet $animal): Pet
    {
        $this->entityManager->remove($animal);
        $this->entityManager->flush();

        return $animal;
    }
}