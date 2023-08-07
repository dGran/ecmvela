<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PublicHoliday;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PublicHoliday>
 *
 * @method PublicHoliday|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublicHoliday|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublicHoliday[]    findAll()
 * @method PublicHoliday[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicHolidayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublicHoliday::class);
    }

    public function save(PublicHoliday $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PublicHoliday $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByIndexSearchFields(string $search, string $sort, string $direction): array
    {
        return $this->createQueryBuilder('public_holiday')
            ->where('public_holiday.name LIKE :search')
            ->orWhere('public_holiday.date LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->orderBy('public_holiday.'.$sort, $direction)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return PublicHoliday[]
     */
    public function findByMonthAndYear(int $month, int $year): array
    {
        $dateFrom = new \DateTime("$year-$month-01");
        $dateTo = new \DateTime("last day of $year-$month");

        return $this->createQueryBuilder('public_holiday')
            ->where('public_holiday.date BETWEEN :date_from AND :date_to')
            ->setParameter('date_from', $dateFrom)
            ->setParameter('date_to', $dateTo)
            ->orderBy('public_holiday.date', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
