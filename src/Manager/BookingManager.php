<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookingManager
{
    protected EntityManagerInterface $entityManager;
    protected BookingRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Booking::class);
    }

    public function create(): Booking
    {
        return new Booking();
    }

    public function save(Booking $booking): Booking
    {
        $this->entityManager->persist($booking);
        $this->entityManager->flush();

        return $booking;
    }

    public function delete(Booking $booking): Booking
    {
        $this->entityManager->remove($booking);
        $this->entityManager->flush();

        return $booking;
    }

    public function findOneById($id): ?Booking
    {
        /** @var Booking $booking */
        $booking = $this->repository->find($id);

        return $booking;
    }

    public function findOneBy(array $criteria, array $orderBy = null): Booking
    {
        /** @var Booking $booking */
        $booking = $this->repository->findOneBy($criteria, $orderBy);

        return $booking;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @return Booking[]
     */
    public function findByDateFromAndDateTo(\DateTime $dateFrom, \DateTime $dateTo): array
    {
        return $this->repository->findByDateFromAndDateTo($dateFrom, $dateTo);
    }
}