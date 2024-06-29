<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class OrderRepository
{
	private EntityManagerInterface $entityManager;
	private EntityRepository $repository;
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
		$this->repository = $entityManager->getRepository(Order::class);
	}

	public function saveOrderToDatabase(Order $storefront): int
	{
		$this->entityManager->persist($storefront);
		$this->entityManager->flush();
		return $storefront->getOrderId();
	}

	public function findOrderInDatabase(int $id): ?Order
	{
		return $this->repository->findOneBy(['orderId' => $id]);
	}
}