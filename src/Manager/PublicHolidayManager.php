<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\PublicHoliday;
use App\Repository\PublicHolidayRepository;
use Doctrine\ORM\EntityManagerInterface;

class PublicHolidayManager
{
    protected EntityManagerInterface $entityManager;
    protected PublicHolidayRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(PublicHoliday::class);
    }

    public function create(): PublicHoliday
    {
        return new PublicHoliday();
    }

    public function save(PublicHoliday $publicHoliday): PublicHoliday
    {
        $this->entityManager->persist($publicHoliday);
        $this->entityManager->flush();

        return $publicHoliday;
    }

    public function delete(PublicHoliday $publicHoliday): PublicHoliday
    {
        $this->entityManager->remove($publicHoliday);
        $this->entityManager->flush();

        return $publicHoliday;
    }

    public function findOneById($id): ?PublicHoliday
    {
        /** @var PublicHoliday $publicHoliday */
        $publicHoliday = $this->repository->find($id);

        return $publicHoliday;
    }

    public function findOneBy(array $criteria, array $orderBy = null): PublicHoliday
    {
        /** @var PublicHoliday $publicHoliday */
        $publicHoliday = $this->repository->findOneBy($criteria, $orderBy);

        return $publicHoliday;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }
}