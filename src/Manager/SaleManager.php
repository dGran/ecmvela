<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Sale;
use App\Repository\SaleRepository;
use Doctrine\ORM\EntityManagerInterface;

class SaleManager
{
    protected EntityManagerInterface $entityManager;
    protected SaleRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Sale::class);
    }

    public function create(): Sale
    {
        return new Sale();
    }

    /**
     * @param $sale
     * @return mixed
     */
    public function save($sale): Sale
    {
        $this->entityManager->persist($sale);
        $this->entityManager->flush();

        return $sale;
    }

    public function update(Sale $sale): Sale
    {
        $sale->setDateUpd(new \DateTime());

        $this->entityManager->persist($sale);
        $this->entityManager->flush();

        return $sale;
    }

    public function delete(Sale $sale): Sale
    {
        $this->entityManager->remove($sale);
        $this->entityManager->flush();

        return $sale;
    }

    public function findOneById($id): ?Sale
    {
        /** @var Sale $sale */
        $sale = $this->repository->find($id);

        return $sale;
    }

    public function findOneBy(array $criteria, array $orderBy = null): Sale
    {
        /** @var Sale $sale */
        $sale = $this->repository->findOneBy($criteria, $orderBy);

        return $sale;
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