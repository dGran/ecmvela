<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\HairType;
use App\Repository\HairTypeRepository;
use Doctrine\ORM\EntityManagerInterface;

class HairTypeManager
{
    protected EntityManagerInterface $entityManager;
    protected HairTypeRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(HairType::class);
    }

    public function create(): HairType
    {
        return new HairType();
    }

    /**
     * @param $hairType
     * @return mixed
     */
    public function save($hairType): HairType
    {
        $this->entityManager->persist($hairType);
        $this->entityManager->flush();

        return $hairType;
    }

    public function delete(HairType $hairType): HairType
    {
        $this->entityManager->remove($hairType);
        $this->entityManager->flush();

        return $hairType;
    }

    public function findOneById($id): ?HairType
    {
        /** @var HairType $hairType */
        $hairType = $this->repository->find($id);

        return $hairType;
    }

    public function findOneBy(array $criteria): HairType
    {
        /** @var HairType $hairType */
        $hairType = $this->repository->findOneBy($criteria);

        return $hairType;
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