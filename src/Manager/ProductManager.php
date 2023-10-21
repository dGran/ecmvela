<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductManager
{
    protected EntityManagerInterface $entityManager;
    protected ProductRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Product::class);
    }

    public function create(): Product
    {
        return new Product();
    }

    public function save(Product $product): Product
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }

    public function update(Product $product): Product
    {
        $product->setDateUpd(new \DateTime());

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }

    public function delete(Product $product): Product
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return $product;
    }

    public function findOneById($id): ?Product
    {
        /** @var Product $product */
        $product = $this->repository->find($id);

        return $product;
    }

    public function findOneBy(array $criteria, array $orderBy = null): Product
    {
        /** @var Product $product */
        $product = $this->repository->findOneBy($criteria, $orderBy);

        return $product;
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
