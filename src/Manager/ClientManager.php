<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;

class ClientManager
{
    protected EntityManagerInterface $entityManager;
    protected ClientRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Client::class);
    }

    public function create(): Client
    {
        return new Client();
    }

    public function save(Client $customer): Client
    {
        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }

    public function delete(Client $customer): Client
    {
        $this->entityManager->remove($customer);
        $this->entityManager->flush();

        return $customer;
    }

    public function findOneById($id): ?Client
    {
        /** @var Client $customer */
        $customer = $this->repository->find($id);

        return $customer;
    }

    public function findOneBy(array $criteria, array $orderBy = null): Client
    {
        /** @var Client $customer */
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
}
