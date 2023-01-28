<?php

namespace App\Repository;

use App\Entity\HairType;
use Doctrine\ORM\EntityRepository;

/**
 * @method HairType|null find($id, $lockMode = null, $lockVersion = null)
 * @method HairType|null findOneBy(array $criteria, array $orderBy = null)
 * @method HairType[]    findAll()
 * @method HairType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HairTypeRepository extends EntityRepository
{
}
