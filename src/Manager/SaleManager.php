<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Customer;
use App\Entity\Pet;
use App\Entity\Sale;
use App\Repository\SaleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

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

    public function findByIndexSearchFields(string $search): array
    {
        return $this->repository->findByIndexSearchFields($search);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getTotalByDateRange(\DateTime $dateFrom, \DateTime $dateTo): ?float
    {
        return $this->repository->getTotalByDateRange($dateFrom, $dateTo);
    }

    /**
     * @return Sale[]
     */
    public function findByDate(string $date): array
    {
        return $this->repository->findByDate($date);
    }

    /**
     * @return Sale[]
     */
    public function findByDateRange(\DateTime $dateFrom, \DateTime $dateTo): array
    {
        return $this->repository->findByDateRange($dateFrom, $dateTo);
    }

    /**
     * @return array<int, array{total: float, numberOfSales: float, day: string}>
     */
    public function findByRangeDateGroupedByDay(\DateTime $dateFrom, \DateTime $dateTo): array
    {
        return $this->repository->findByRangeDateGroupedByDay($dateFrom, $dateTo);
    }

    /**
     * @return array<int, array{total: float, week: int, year: int}>
     */
    public function findByRangeDateGroupedByWeek(\DateTime $dateFrom, \DateTime $dateTo): array
    {
        return $this->repository->findByRangeDateGroupedByWeek($dateFrom, $dateTo);
    }

    /**
     * @return array<int, array{total: float, month: int, year: int}>
     */
    public function findByRangeDateGroupedByMonth(\DateTime $dateFrom, \DateTime $dateTo): array
    {
        return $this->repository->findByRangeDateGroupedByMonth($dateFrom, $dateTo);
    }

    /**
     * @return Sale[]
     */
    public function findByPetId(int $petId): array
    {
        return $this->repository->findByPetId($petId);
    }
}