<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\ProductStock;
use App\Repository\ProductStockRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductStockManager
{
    protected EntityManagerInterface $entityManager;
    protected ProductStockRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ProductStock::class);
    }

    public function create(): ProductStock
    {
        return new ProductStock();
    }

    /**
     * @param $productStock
     * @return mixed
     */
    public function save($productStock): ProductStock
    {
        $this->entityManager->persist($productStock);
        $this->entityManager->flush();

        return $productStock;
    }

    public function delete(ProductStock $productStock): ProductStock
    {
        $this->entityManager->remove($productStock);
        $this->entityManager->flush();

        return $productStock;
    }

    public function findOneById($id): ?ProductStock
    {
        /** @var ProductStock $productStock */
        $productStock = $this->repository->find($id);

        return $productStock;
    }

    public function findOneBy(array $criteria, array $orderBy = null): ProductStock
    {
        /** @var ProductStock $productStock */
        $productStock = $this->repository->findOneBy($criteria, $orderBy);

        return $productStock;
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
