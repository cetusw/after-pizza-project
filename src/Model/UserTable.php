<?php

namespace App\Model;

class UserTable
{
	public function __construct(private \PDO $connection)
	{
	}
	public function saveUserToDatabase(User $user): int
	{
		try {
			$hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
			$query = "INSERT INTO user (login, email, phone, password, avatar_path) 
    	VALUES (:login, :email, :phone, :password, :avatar_path)";
			$statement = $this->connection->prepare($query);
			$statement->execute([
				':login' => $user->getLogin(),
				':email' => $user->getEmail(),
				':phone' => $user->getPhone(),
			  ':password' => $hashedPassword,
				':avatar_path' => $user->getAvatarPath(),
			]);
		} catch (\PDOException $e) {
			throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
		}
		return (int)$this->connection->lastInsertId();
	}

	public function findUserByLogin(string $login): int
	{
		try {
			$query = "SELECT id, login, email, phone, password, avatar_path FROM user WHERE login = :login";
			$statement = $this->connection->prepare($query);
			$statement->bindParam(':login', $login);
			$statement->execute();
			if ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
				return $row['id'];
			}
		} catch (\PDOException $e) {
			throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
		}
		return 0;
	}

	public function checkPassword(int $userId, string $password): bool
	{
		$query = "SELECT password FROM user WHERE id = $userId";
		$statement = $this->connection->query($query);
		if ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
			if (password_verify($password, $row['password'])) {
				return true;
			}
		}
		return false;
	}

	private function createUserFromRow(array $row): User
	{
		// Ensure that all required keys are present in the array
		$requiredKeys = ['id', 'login', 'email', 'password'];
		foreach ($requiredKeys as $key) {
			if (!array_key_exists($key, $row)) {
				throw new \InvalidArgumentException("Missing required key: $key");
			}
		}

		// Create and return the User object
		return new User(
			(int)$row['id'],
			$row['login'],
			$row['email'],
			$row['phone'] ?? null,
			$row['password'],
			$row['avatar_path'] ?? null
		);
	}

	public function addPathToDatabase($userId, string $path): void {
		$query = "UPDATE user SET avatar_path = '$path' WHERE id = $userId;";
		$statement = $this->connection->prepare($query);
		$statement->execute();
	}

	public function updateUserInDatabase(User $user): void
	{
		$hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
		$query = "UPDATE user SET
              login = :login,
              email = :email,
              phone = :phone,
              password = :password,
              avatar_path = :avatar_path  
              WHERE id = :id";
		$statement = $this->connection->prepare($query);
		$statement->execute([
			':login' => $user->getLogin(),
			':email' => $user->getEmail(),
			':phone' => $user->getPhone(),
			':password' => $hashedPassword,
			':avatar_path' => $user->getAvatarPath(),
			':user_id' => $user->getId()
		]);
	}
}