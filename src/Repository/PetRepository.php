<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Pet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pet>
 *
 * @method Pet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pet[]    findAll()
 * @method Pet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pet::class);
    }

    public function findByIndexSearchFields(string $search, string $sort, string $direction): array
    {
        return $this->createQueryBuilder('pet')
            ->leftJoin('pet.customer', 'customer')
            ->leftJoin('pet.breed', 'breed')
            ->where('pet.name LIKE :search')
            ->orWhere('customer.name LIKE :search')
            ->orWhere('breed.name LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->orderBy('pet.'.$sort, $direction)
            ->getQuery()
            ->getResult();
    }
}