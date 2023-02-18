<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\PetCategory;
use App\Repository\AnimalTypeRepository;
use Doctrine\ORM\EntityManagerInterface;

class AnimalTypeManager
{
    protected EntityManagerInterface $entityManager;
    protected AnimalTypeRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(PetCategory::class);
    }

    public function create(): PetCategory
    {
        return new PetCategory();
    }

    /**
     * @param $animalType
     * @return mixed
     */
    public function save($animalType): PetCategory
    {
        $this->entityManager->persist($animalType);
        $this->entityManager->flush();

        return $animalType;
    }

    public function delete(PetCategory $animalType): PetCategory
    {
        $this->entityManager->remove($animalType);
        $this->entityManager->flush();

        return $animalType;
    }

    public function findOneById($id): ?PetCategory
    {
        /** @var PetCategory $animalType */
        $animalType = $this->repository->find($id);

        return $animalType;
    }

    public function findOneBy(array $criteria): PetCategory
    {
        /** @var PetCategory $animalType */
        $animalType = $this->repository->findOneBy($criteria);

        return $animalType;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria): array
    {
        return $this->repository->findBy($criteria);
    }
}