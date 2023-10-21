<?php

declare(strict_types=1);

namespace App\Model;

interface EntityManagerInterface
{
    /**
     * Finds one entity by id
     */
    public function findOneById($id): mixed;

    /**
     * Finds one entity by the given criteria
     */
    public function findOneBy(array $criteria): mixed;

    /**
     * Finds all entities.
     */
    public function findAll(): mixed;

    /**
     * Finds entities by the given criteria
     */
    public function findBy(array $criteria): mixed;

    /**
     * Creates an empty entity instance
     */
    public function create(): mixed;

    /**
     * Saves a entity
     */
    public function save($entity): mixed;
}
