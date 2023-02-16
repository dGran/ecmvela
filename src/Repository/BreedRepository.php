<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Breed;
use Doctrine\ORM\EntityRepository;

/**
 * @method Breed|null find($id, $lockMode = null, $lockVersion = null)
 * @method Breed|null findOneBy(array $criteria, array $orderBy = null)
 * @method Breed[]    findAll()
 * @method Breed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BreedRepository extends EntityRepository
{
}
