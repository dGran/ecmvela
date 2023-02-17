<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\DogSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DogSize>
 *
 * @method DogSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method DogSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method DogSize[]    findAll()
 * @method DogSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DogSizeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DogSize::class);
    }
}
