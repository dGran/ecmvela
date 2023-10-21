<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;

class ServiceManager
{
    protected EntityManagerInterface $entityManager;
    protected ServiceRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Service::class);
    }

    public function create(): Service
    {
        return new Service();
    }

    /**
     * @param $service
     * @return mixed
     */
    public function save($service): Service
    {
        $this->entityManager->persist($service);
        $this->entityManager->flush();

        return $service;
    }

    public function delete(Service $service): Service
    {
        $this->entityManager->remove($service);
        $this->entityManager->flush();

        return $service;
    }

    public function findOneById($id): ?Service
    {
        /** @var Service $service */
        $service = $this->repository->find($id);

        return $service;
    }

    public function findOneBy(array $criteria, array $orderBy = null): Service
    {
        /** @var Service $service */
        $service = $this->repository->findOneBy($criteria, $orderBy);

        return $service;
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
