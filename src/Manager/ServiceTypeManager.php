<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\ServiceType;
use App\Repository\ServiceTypeRepository;
use Doctrine\ORM\EntityManagerInterface;

class ServiceTypeManager
{
    protected EntityManagerInterface $entityManager;
    protected ServiceTypeRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ServiceType::class);
    }

    public function create(): ServiceType
    {
        return new ServiceType();
    }

    /**
     * @param $serviceType
     * @return mixed
     */
    public function save($serviceType): ServiceType
    {
        $this->entityManager->persist($serviceType);
        $this->entityManager->flush();

        return $serviceType;
    }

    public function delete(ServiceType $serviceType): ServiceType
    {
        $this->entityManager->remove($serviceType);
        $this->entityManager->flush();

        return $serviceType;
    }

    public function findOneById($id): ?ServiceType
    {
        /** @var ServiceType $serviceType */
        $serviceType = $this->repository->find($id);

        return $serviceType;
    }

    public function findOneBy(array $criteria, array $orderBy = null): ServiceType
    {
        /** @var ServiceType $serviceType */
        $serviceType = $this->repository->findOneBy($criteria, $orderBy);

        return $serviceType;
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