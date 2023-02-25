<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PetSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PetSize>
 *
 * @method PetSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method PetSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method PetSize[]    findAll()
 * @method PetSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetSizeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PetSize::class);
    }
}
