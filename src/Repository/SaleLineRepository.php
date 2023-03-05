<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SaleLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SaleLine>
 *
 * @method SaleLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method SaleLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method SaleLine[]    findAll()
 * @method SaleLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaleLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SaleLine::class);
    }
}
