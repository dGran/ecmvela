<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\TaxType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaxType>
 *
 * @method TaxType|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaxType|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaxType[]    findAll()
 * @method TaxType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaxType::class);
    }
}
