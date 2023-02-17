<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\AnimalType;
use App\Repository\AnimalTypeRepository;
use Doctrine\ORM\EntityManagerInterface;

class AnimalTypeManager
{
    protected EntityManagerInterface $entityManager;
    protected AnimalTypeRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(AnimalType::class);
    }

    public function create(): AnimalType
    {
        return new AnimalType();
    }

    /**
     * @param $animalType
     * @return mixed
     */
    public function save($animalType): AnimalType
    {
        $this->entityManager->persist($animalType);
        $this->entityManager->flush();

        return $animalType;
    }

    public function delete(AnimalType $animalType): AnimalType
    {
        $this->entityManager->remove($animalType);
        $this->entityManager->flush();

        return $animalType;
    }

    public function findOneById($id): ?AnimalType
    {
        /** @var AnimalType $animalType */
        $animalType = $this->repository->find($id);

        return $animalType;
    }

    public function findOneBy(array $criteria): AnimalType
    {
        /** @var AnimalType $animalType */
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