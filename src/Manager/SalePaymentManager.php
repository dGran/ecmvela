<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Sale;
use App\Entity\SalePayment;
use App\Repository\SalePaymentRepository;
use Doctrine\ORM\EntityManagerInterface;

class SalePaymentManager
{
    protected EntityManagerInterface $entityManager;
    protected SalePaymentRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(SalePayment::class);
    }

    public function create(): SalePayment
    {
        return new SalePayment();
    }

    /**
     * @param $salePayment
     * @return mixed
     */
    public function save($salePayment): SalePayment
    {
        $this->entityManager->persist($salePayment);
        $this->entityManager->flush();

        return $salePayment;
    }

    public function delete(SalePayment $salePayment): SalePayment
    {
        $this->entityManager->remove($salePayment);
        $this->entityManager->flush();

        return $salePayment;
    }

    public function findOneById($id): ?SalePayment
    {
        /** @var SalePayment $salePayment */
        $salePayment = $this->repository->find($id);

        return $salePayment;
    }

    public function findOneBy(array $criteria, array $orderBy = null): SalePayment
    {
        /** @var SalePayment $salePayment */
        $salePayment = $this->repository->findOneBy($criteria, $orderBy);

        return $salePayment;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function deleteFromSale(Sale $sale): void
    {
        foreach ($sale->getSalePayments() as $salePayment) {
            $this->delete($salePayment);
        }
    }
}