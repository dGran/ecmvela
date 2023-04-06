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

    public function save(Customer $customer): Customer
    {
        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }

    public function update(Customer $customer): Customer
    {
        $customer->setDateUpd(new \DateTime());

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

    public function findOneBy(array $criteria, array $orderBy = null): Customer
    {
        /** @var Customer $customer */
        $customer = $this->repository->findOneBy($criteria, $orderBy);

        return $customer;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function findByIndexSearchFields(string $search): array
    {
        return $this->repository->findByIndexSearchFields($search);
    }

    public function findByName(string $name): array
    {
        return $this->repository->findByName($name);
//        $customers = $this->repository->findByName($name);
//        $results = [];
//
//        foreach ($customers as $customer) {
//            $results[] = [
//                'id' => $customer->getId(),
//                'name' => $customer->getName(),
//                'email' => $customer->getEmail(),
//                'phone' => $customer->getPhone()
//            ];
//        }
//
//        return $results;
    }
}