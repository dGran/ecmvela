<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Sale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
}
