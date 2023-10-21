<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class CategoryManager
{
    protected EntityManagerInterface $entityManager;
    protected CategoryRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Category::class);
    }

    public function create(): Category
    {
        return new Category();
    }

    /**
     * @param $category
     * @return mixed
     */
    public function save($category): Category
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }

    public function delete(Category $category): Category
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return $category;
    }

    public function findOneById($id): ?Category
    {
        /** @var Category $category */
        $category = $this->repository->find($id);

        return $category;
    }

    public function findOneBy(array $criteria, array $orderBy = null): Category
    {
        /** @var Category $category */
        $category = $this->repository->findOneBy($criteria, $orderBy);

        return $category;
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
