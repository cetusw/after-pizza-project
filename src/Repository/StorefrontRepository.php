<?php

namespace App\Repository;

use App\Entity\Storefront;
use App\Entity\User;
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
}