<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\DogSize;
use App\Repository\DogSizeRepository;
use Doctrine\ORM\EntityManagerInterface;

class DogSizeManager
{
    protected EntityManagerInterface $entityManager;
    protected DogSizeRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(DogSize::class);
    }

    public function create(): DogSize
    {
        return new DogSize();
    }

    /**
     * @param $dogSize
     * @return mixed
     */
    public function save($dogSize): DogSize
    {
        $this->entityManager->persist($dogSize);
        $this->entityManager->flush();

        return $dogSize;
    }

    public function delete(DogSize $dogSize): DogSize
    {
        $this->entityManager->remove($dogSize);
        $this->entityManager->flush();

        return $dogSize;
    }

    public function findOneById($id): ?DogSize
    {
        /** @var DogSize $dogSize */
        $dogSize = $this->repository->find($id);

        return $dogSize;
    }

    public function findOneBy(array $criteria): DogSize
    {
        /** @var DogSize $dogSize */
        $dogSize = $this->repository->findOneBy($criteria);

        return $dogSize;
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