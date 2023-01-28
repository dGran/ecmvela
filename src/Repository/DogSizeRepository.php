<?php

namespace App\Repository;

use App\Entity\DogSize;
use Doctrine\ORM\EntityRepository;

/**
 * @method DogSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method DogSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method DogSize[]    findAll()
 * @method DogSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DogSizeRepository extends EntityRepository
{
}
