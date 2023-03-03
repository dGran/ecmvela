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
     * @param $petSize
     * @return mixed
     */
    public function save($petSize): PetSize
    {
        $this->entityManager->persist($petSize);
        $this->entityManager->flush();

        return $petSize;
    }

    public function delete(PetSize $petSize): PetSize
    {
        $this->entityManager->remove($petSize);
        $this->entityManager->flush();

        return $petSize;
    }

    public function findOneById($id): ?PetSize
    {
        /** @var PetSize $petSize */
        $petSize = $this->repository->find($id);

        return $petSize;
    }

    public function findOneBy(array $criteria, array $orderBy = null): PetSize
    {
        /** @var PetSize $petSize */
        $petSize = $this->repository->findOneBy($criteria, $orderBy);

        return $petSize;
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