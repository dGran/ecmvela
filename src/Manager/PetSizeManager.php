<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\PetSize;
use App\Repository\PetSizeRepository;
use Doctrine\ORM\EntityManagerInterface;

class PetSizeManager
{
    protected EntityManagerInterface $entityManager;
    protected PetSizeRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(PetSize::class);
    }

    public function create(): PetSize
    {
        return new PetSize();
    }

    /**
     * @param $dogSize
     * @return mixed
     */
    public function save($dogSize): PetSize
    {
        $this->entityManager->persist($dogSize);
        $this->entityManager->flush();

        return $dogSize;
    }

    public function delete(PetSize $dogSize): PetSize
    {
        $this->entityManager->remove($dogSize);
        $this->entityManager->flush();

        return $dogSize;
    }

    public function findOneById($id): ?PetSize
    {
        /** @var PetSize $dogSize */
        $dogSize = $this->repository->find($id);

        return $dogSize;
    }

    public function findOneBy(array $criteria, array $orderBy = null): PetSize
    {
        /** @var PetSize $dogSize */
        $dogSize = $this->repository->findOneBy($criteria, $orderBy);

        return $dogSize;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }
}