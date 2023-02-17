<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AnimalType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimalType>
 *
 * @method AnimalType|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimalType|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimalType[]    findAll()
 * @method AnimalType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalType::class);
    }
}
