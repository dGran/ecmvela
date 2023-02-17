<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;

class CustomerManager
{
    protected EntityManagerInterface $entityManager;
    protected CustomerRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Customer::class);
    }

    public function create(): Customer
    {
        return new Customer();
    }

    /**
     * @param $customer
     * @return mixed
     */
    public function save($customer): Customer
    {
        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }

    public function delete(Customer $customer): Customer
    {
        $this->entityManager->remove($customer);
        $this->entityManager->flush();

        return $customer;
    }

    public function findOneById($id): ?Customer
    {
        /** @var Customer $customer */
        $customer = $this->repository->find($id);

        return $customer;
    }

    public function findOneBy(array $criteria): Customer
    {
        /** @var Customer $customer */
        $customer = $this->repository->findOneBy($criteria);

        return $customer;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria): array
    {
        return $this->repository->findBy($criteria);
    }

    public function findBySearch(string $name): array
    {
        return $this->repository->findBySearch($name);
    }
}