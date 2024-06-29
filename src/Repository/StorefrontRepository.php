<?php

namespace App\Repository;

use App\Entity\Storefront;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class StorefrontRepository
{
	private EntityManagerInterface $entityManager;
	private EntityRepository $repository;
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
		$this->repository = $entityManager->getRepository(Storefront::class);
	}

	public function findProductsInDatabase(): array
	{
		return $this->repository->findAll();
	}

	public function findProductInDatabase(int $id): ?Storefront
	{
		return $this->repository->findOneBy(['id' => $id]);
	}

	public function saveProductToDatabase(Storefront $storefront): int
	{
		$this->entityManager->persist($storefront);
		$this->entityManager->flush();
		return $storefront->getId();
	}

	public function deleteProductFromDatabase(Storefront $storefront): void
	{
		$this->entityManager->remove($storefront);
		$this->entityManager->flush();
	}

	public function addPathToProductDatabase(int $id, string $path): void
	{

	}
}