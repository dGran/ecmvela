<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Pet;
use App\Repository\PetRepository;
use Doctrine\ORM\EntityManagerInterface;

class PetManager
{
    protected EntityManagerInterface $entityManager;
    protected PetRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Pet::class);
    }

    public function create(): Pet
    {
        return new Pet();
    }

    /**
     * @param $pet
     * @return mixed
     */
    public function save($pet): Pet
    {
        $this->entityManager->persist($pet);
        $this->entityManager->flush();

        return $pet;
    }

    public function delete(Pet $pet): Pet
    {
        $this->entityManager->remove($pet);
        $this->entityManager->flush();

        return $pet;
    }

    public function findOneById($id): ?Pet
    {
        /** @var Pet $pet */
        $pet = $this->repository->find($id);

        return $pet;
    }

    public function findOneBy(array $criteria): Pet
    {
        /** @var Pet $pet */
        $pet = $this->repository->findOneBy($criteria);

        return $pet;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria): array
    {
        return $this->repository->findBy($criteria);
    }

    public function findByIndexSearchFields(string $name): array
    {
        return $this->repository->findByIndexSearchFields($name);
    }
}