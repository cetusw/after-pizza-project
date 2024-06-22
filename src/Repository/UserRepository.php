<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository
{

	private EntityManagerInterface $entityManager;
	private EntityRepository $repository;
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
		$this->repository = $entityManager->getRepository(User::class);
	}

	public function saveUserToDatabase(User $user): int
	{
		$this->entityManager->persist($user);
		$this->entityManager->flush();
		return $user->getId();
	}

	public function findUserByLogin(string $login): ?User
	{
		return $this->repository->findOneBy(['login' => $login]);
	}

	public function getCurrentUser(): ?User
	{
		session_name('auth');
		session_start();
		return $this->repository->findOneBy(['id' => $_SESSION['user_id']]);
	}

	public function checkPassword(int $userId, string $password): bool
	{
		$user = $this->repository->findOneBy(['id' => $userId]);
		if (password_verify($password, $user->getPassword())) {
			return true;
		}
		return false;
	}

	public function addPathToDatabase($userId, string $path): void {
		$query = "UPDATE user SET avatar_path = '$path' WHERE id = $userId;";
		$statement = $this->connection->prepare($query);
		$statement->execute();
	}
}