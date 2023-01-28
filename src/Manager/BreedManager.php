<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Breed;
use App\Repository\BreedRepository;
use Doctrine\ORM\EntityManagerInterface;

class BreedManager
{
    protected EntityManagerInterface $entityManager;
    protected BreedRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Breed::class);
    }

    public function create(): Breed
    {
        return new Breed();
    }

    /**
     * @param $breed
     * @return mixed
     */
    public function save($breed): Breed
    {
        $this->entityManager->persist($breed);
        $this->entityManager->flush();

        return $breed;
    }

    public function delete(Breed $breed): Breed
    {
        $this->entityManager->remove($breed);
        $this->entityManager->flush();

        return $breed;
    }

    public function findOneById($id): ?Breed
    {
        /** @var Breed $dogSize */
        $dogSize = $this->repository->find($id);

        return $dogSize;
    }

    public function findOneBy(array $criteria): Breed
    {
        /** @var Breed $dogSize */
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