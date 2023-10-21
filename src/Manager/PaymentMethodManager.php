<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\PaymentMethod;
use App\Repository\PaymentMethodRepository;
use Doctrine\ORM\EntityManagerInterface;

class PaymentMethodManager
{
    protected EntityManagerInterface $entityManager;
    protected PaymentMethodRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(PaymentMethod::class);
    }

    public function create(): PaymentMethod
    {
        return new PaymentMethod();
    }

    /**
     * @param $paymentMethod
     * @return mixed
     */
    public function save($paymentMethod): PaymentMethod
    {
        $this->entityManager->persist($paymentMethod);
        $this->entityManager->flush();

        return $paymentMethod;
    }

    public function delete(PaymentMethod $paymentMethod): PaymentMethod
    {
        $this->entityManager->remove($paymentMethod);
        $this->entityManager->flush();

        return $paymentMethod;
    }

    public function findOneById($id): ?PaymentMethod
    {
        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = $this->repository->find($id);

        return $paymentMethod;
    }

    public function findOneBy(array $criteria, array $orderBy = null): PaymentMethod
    {
        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = $this->repository->findOneBy($criteria, $orderBy);

        return $paymentMethod;
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
