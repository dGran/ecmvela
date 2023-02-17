<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\HairType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HairType>
 *
 * @method HairType|null find($id, $lockMode = null, $lockVersion = null)
 * @method HairType|null findOneBy(array $criteria, array $orderBy = null)
 * @method HairType[]    findAll()
 * @method HairType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HairTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HairType::class);
    }
}
