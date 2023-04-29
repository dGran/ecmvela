<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PaymentMethod;
use App\Entity\SalePayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getTotalBizumPaymentMethodByRangeDates(\DateTime $dateFrom, \DateTime $dateTo): ?float
    {
        return $this->createQueryBuilder('sale_payment')
            ->join('sale_payment.sale', 'sale')
            ->select('SUM(sale_payment.amount) AS total')
            ->where('sale_payment.paymentMethod = :paymentMethodBizumId')
            ->andWhere('sale.dateAdd BETWEEN :dateFrom AND :dateTo')
            ->setParameter('paymentMethodBizumId', PaymentMethod::BIZUM_METHOD_ID)
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getTotalCashPaymentMethodByRangeDates(\DateTime $dateFrom, \DateTime $dateTo): ?float
    {
        return $this->createQueryBuilder('sale_payment')
            ->join('sale_payment.sale', 'sale')
            ->select('SUM(sale_payment.amount) AS total')
            ->where('sale_payment.paymentMethod = :paymentMethodBizumId')
            ->andWhere('sale.dateAdd BETWEEN :dateFrom AND :dateTo')
            ->setParameter('paymentMethodBizumId', PaymentMethod::CASH_METHOD_ID)
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
