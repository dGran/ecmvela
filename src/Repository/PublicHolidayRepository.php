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
}
