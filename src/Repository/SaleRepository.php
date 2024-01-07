<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Customer;
use App\Entity\Pet;
use App\Entity\Sale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sale>
 *
 * @method Sale|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sale|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sale[]    findAll()
 * @method Sale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sale::class);
    }

    public function findByIndexSearchFields(string $search): array
    {
        return $this->createQueryBuilder('sale')
            ->leftJoin('sale.pet', 'pet')
            ->leftJoin('sale.customer', 'customer')
            ->where('pet.name LIKE :search')
            ->orWhere('customer.name LIKE :search')
            ->orWhere('sale.dateAdd LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->orderBy('sale.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getTotalByDateRange(\DateTime $dateFrom, \DateTime $dateTo): ?float
    {
        return $this->createQueryBuilder('sale')
            ->select('SUM(sale.total) AS total')
            ->where('sale.dateAdd >= :dateFrom')
            ->andWhere('sale.dateAdd <= :dateTo')
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return Sale[]
     */
    public function findByDate(string $date): array
    {
        return $this->createQueryBuilder('sale')
            ->select('sale, pet, customer')
            ->leftJoin('sale.pet', 'pet')
            ->leftJoin('sale.customer', 'customer')
            ->where('DATE(sale.dateAdd) = :date')
            ->orderBy('sale.dateAdd', 'DESC')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Sale[]
     */
    public function findByDateRange(\DateTime $dateFrom, \DateTime $dateTo): array
    {
        return $this->createQueryBuilder('sale')
            ->select('sale, pet, customer')
            ->leftJoin('sale.pet', 'pet')
            ->leftJoin('sale.customer', 'customer')
            ->where('sale.dateAdd BETWEEN :date_from AND :date_to')
            ->orderBy('sale.dateAdd', 'DESC')
            ->setParameter('date_from', $dateFrom)
            ->setParameter('date_to', $dateTo)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<int, array{total: float, numberOfSales: float, day: string}>
     */
    public function findByRangeDateGroupedByDay(\DateTime $dateFrom, \DateTime $dateTo): array
    {
        return $this->createQueryBuilder('sale')
            ->select('SUM(sale.total) AS total', 'COUNT(sale.id) as numberOfSales', 'DATE(sale.dateAdd) as day')
            ->where('sale.dateAdd BETWEEN :date_from AND :date_to')
            ->orderBy('day', 'DESC')
            ->groupBy('day')
            ->setParameter('date_from', $dateFrom)
            ->setParameter('date_to', $dateTo)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<int, array{total: float, week: int, year: int}>
     */
    public function findByRangeDateGroupedByWeek(\DateTime $dateFrom, \DateTime $dateTo): array
    {
        return $this->createQueryBuilder('sale')
            ->select('SUM(sale.total) AS total', 'WEEK(sale.dateAdd) as week', 'YEAR(sale.dateAdd) as year')
            ->where('sale.dateAdd BETWEEN :date_from AND :date_to')
            ->groupBy('year, week')
            ->orderBy('year', 'DESC')
            ->addOrderBy('week', 'DESC')
            ->setParameter('date_from', $dateFrom)
            ->setParameter('date_to', $dateTo)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<int, array{total: float, month: int, year: int}>
     */
    public function findByRangeDateGroupedByMonth(\DateTime $dateFrom, \DateTime $dateTo): array
    {
        return $this->createQueryBuilder('sale')
            ->select('SUM(sale.total) AS total', 'MONTH(sale.dateAdd) as month', 'YEAR(sale.dateAdd) as year')
            ->where('sale.dateAdd BETWEEN :date_from AND :date_to')
            ->orderBy('month', 'DESC')
            ->groupBy('month')
            ->setParameter('date_from', $dateFrom)
            ->setParameter('date_to', $dateTo)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Sale[]
     */
    public function findByPetId(int $petId): array
    {
        return $this->createQueryBuilder('sale')
            ->where('sale.pet = :pet_id')
            ->orderBy('sale.dateAdd', 'DESC')
            ->setParameter('pet_id', $petId)
            ->getQuery()
            ->getResult();
    }
}
