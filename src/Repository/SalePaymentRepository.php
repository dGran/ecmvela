<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PaymentMethod;
use App\Entity\Sale;
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

    public function getTotalByDateRangeAndPaymentMethod(\DateTime $dateFrom, \DateTime $dateTo, int $paymentMethodId): ?float
    {
        $results = $this->createQueryBuilder('sale_payment')
            ->select('DISTINCT(sale.id) as sale_id, sale_payment.amount as amount')
            ->innerJoin('sale_payment.sale', 'sale')
            ->where('sale_payment.paymentMethod = :payment_method_id')
            ->andWhere('sale.dateAdd BETWEEN :dateFrom AND :dateTo')
            ->setParameter('payment_method_id', $paymentMethodId)
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
            ->getQuery()
            ->getResult();

        return \array_sum(\array_column($results, 'amount'));
    }

    public function getTotalByDateRangeAndPaymentMethodNotCash(\DateTime $dateFrom, \DateTime $dateTo): ?float
    {
        $results = $this->createQueryBuilder('sale_payment')
        ->select('DISTINCT(sale.id) as sale_id, sale_payment.amount as amount')
        ->innerJoin('sale_payment.sale', 'sale')
        ->where('sale_payment.paymentMethod <> :payment_method_id')
        ->andWhere('sale.dateAdd BETWEEN :dateFrom AND :dateTo')
        ->setParameter('payment_method_id', PaymentMethod::CASH_METHOD_ID)
        ->setParameter('dateFrom', $dateFrom)
        ->setParameter('dateTo', $dateTo)
        ->getQuery()
        ->getResult();

        return \array_sum(\array_column($results, 'amount'));
    }

    /**
     * @return Sale[]
     */
    public function getSaleByDateRangeAndPaymentMethodNotCash(\DateTime $dateFrom, \DateTime $dateTo): array
    {
        return $this->createQueryBuilder('sale_payment')
            ->innerJoin('sale_payment.sale', 'sale')
            ->select('DISTINCT(sale.id) as id', 'sale.dateAdd', 'sale.totalWithoutTaxes', 'sale.totalTaxes', 'sale.total')
            ->where('sale_payment.paymentMethod <> :payment_method_id')
            ->andWhere('sale.dateAdd BETWEEN :dateFrom AND :dateTo')
            ->setParameter('payment_method_id', PaymentMethod::CASH_METHOD_ID)
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
            ->orderBy('sale.dateAdd', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
