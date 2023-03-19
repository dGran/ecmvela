<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Sale;
use App\Entity\SaleLine;
use App\Repository\SaleLineRepository;
use Doctrine\ORM\EntityManagerInterface;

class SaleLineManager
{
    protected EntityManagerInterface $entityManager;
    protected SaleLineRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(SaleLine::class);
    }

    public function create(): SaleLine
    {
        return new SaleLine();
    }

    public function save(SaleLine $saleLine): SaleLine
    {
        $this->entityManager->persist($saleLine);
        $this->entityManager->flush();

        return $saleLine;
    }

    public function update(SaleLine $saleLine): SaleLine
    {
        $saleLine->setDateUpd(new \DateTime());

        $this->entityManager->persist($saleLine);
        $this->entityManager->flush();

        return $saleLine;
    }

    public function delete(SaleLine $saleLine): SaleLine
    {
        $this->entityManager->remove($saleLine);
        $this->entityManager->flush();

        return $saleLine;
    }

    public function findOneById($id): ?SaleLine
    {
        /** @var SaleLine $saleLine */
        $saleLine = $this->repository->find($id);

        return $saleLine;
    }

    public function findOneBy(array $criteria, array $orderBy = null): SaleLine
    {
        /** @var SaleLine $saleLine */
        $saleLine = $this->repository->findOneBy($criteria, $orderBy);

        return $saleLine;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function deleteFromSale(Sale $sale): void
    {
        foreach ($sale->getSaleLines() as $saleLine) {
            $this->delete($saleLine);
        }
    }
}