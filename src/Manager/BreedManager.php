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

    public function save($breed): Breed
    {
        $this->entityManager->persist($breed);
        $this->entityManager->flush();

        return $breed;
    }

    public function update(Breed $breed): Breed
    {
        $breed->setDateUpd(new \DateTime());

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
        /** @var Breed $breed */
        $breed = $this->repository->find($id);

        return $breed;
    }

    public function findOneBy(array $criteria, array $orderBy = null): Breed
    {
        /** @var Breed $breed */
        $breed = $this->repository->findOneBy($criteria, $orderBy);

        return $breed;
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
