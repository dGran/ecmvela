<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\PetCategory;
use App\Repository\PetCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class PetCategoryManager
{
    protected EntityManagerInterface $entityManager;
    protected PetCategoryRepository $repository;

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
     * @param $petCategory
     * @return mixed
     */
    public function save($petCategory): PetCategory
    {
        $this->entityManager->persist($petCategory);
        $this->entityManager->flush();

        return $petCategory;
    }

    public function delete(PetCategory $petCategory): PetCategory
    {
        $this->entityManager->remove($petCategory);
        $this->entityManager->flush();

        return $petCategory;
    }

    public function findOneById($id): ?PetCategory
    {
        /** @var PetCategory $petCategory */
        $petCategory = $this->repository->find($id);

        return $petCategory;
    }

    public function findOneBy(array $criteria, array $orderBy = null): PetCategory
    {
        /** @var PetCategory $petCategory */
        $petCategory = $this->repository->findOneBy($criteria, $orderBy);

        return $petCategory;
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