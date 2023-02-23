<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PetCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PetCategory>
 *
 * @method PetCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PetCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PetCategory[]    findAll()
 * @method PetCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PetCategory::class);
    }
}
