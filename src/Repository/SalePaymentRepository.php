<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SalePayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SalePayment>
 *
 * @method SalePayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalePayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalePayment[]    findAll()
 * @method SalePayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalePaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalePayment::class);
    }
}
