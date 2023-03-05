<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\TaxType;
use App\Repository\TaxTypeRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaxTypeManager
{
    protected EntityManagerInterface $entityManager;
    protected TaxTypeRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(TaxType::class);
    }

    public function create(): TaxType
    {
        return new TaxType();
    }

    /**
     * @param $taxType
     * @return mixed
     */
    public function save($taxType): TaxType
    {
        $this->entityManager->persist($taxType);
        $this->entityManager->flush();

        return $taxType;
    }

    public function delete(TaxType $taxType): TaxType
    {
        $this->entityManager->remove($taxType);
        $this->entityManager->flush();

        return $taxType;
    }

    public function findOneById($id): ?TaxType
    {
        /** @var TaxType $taxType */
        $taxType = $this->repository->find($id);

        return $taxType;
    }

    public function findOneBy(array $criteria, array $orderBy = null): TaxType
    {
        /** @var TaxType $taxType */
        $taxType = $this->repository->findOneBy($criteria, $orderBy);

        return $taxType;
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