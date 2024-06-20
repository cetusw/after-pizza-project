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
			$query = "INSERT INTO user (first_name, last_name, email, phone, avatar_path) 
    	VALUES (:first_name, :last_name, :email, :phone, :avatar_path)";
			$statement = $this->connection->prepare($query);
			$statement->execute([
				':first_name' => $user->getFirstName(),
				':last_name' => $user->getLastName(),
				':email' => $user->getEmail(),
				':phone' => $user->getPhone(),
				':avatar_path' => $user->getAvatarPath()
			]);
		} catch (\PDOException $e) {
			throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
		}
		return (int)$this->connection->lastInsertId();
	}

	public function findUserInDatabase(int $userId): ?User
	{
		try {
			$query = "SELECT id, first_name, last_name, email, phone, avatar_path
        FROM user WHERE id = $userId";

			$statement = $this->connection->query($query);
			if ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
				return $this->createUserFromRow($row);
			}
		} catch (\PDOException $e) {
			throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
		}
		return null;
	}

	public function findUsersInDatabase(): array
	{
		try {
			$users = [];
			$query = "SELECT * FROM user";

			$statement = $this->connection->query($query);
			while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
				$users[] = $this->createUserFromRow($row);
			}
			return $users;
		} catch (\PDOException $e) {
			throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
		}
	}

	private function createUserFromRow(array $row): User
	{
		return new User(
			(int)$row['user_id'],
			$row['first_name'],
			$row['last_name'],
			$row['email'],
			$row['phone'] ?? null,
			$row['avatar_path'] ?? null
		);
	}
	public function addPathToDatabase($userId, string $path): void {
		$query = "UPDATE user SET avatar_path = '$path' WHERE user_id = $userId;";
		$statement = $this->connection->prepare($query);
		$statement->execute();
	}

	public function deleteUser(int $userId): void
	{

		$query = "DELETE FROM user WHERE id = $userId;";
		$statement = $this->connection->prepare($query);
		if ($statement->execute()) {
			require __DIR__ . '/../View/delete_user_notification.php';
		}
	}

	public function updateUserInDatabase(User $user): void
	{
		$query = "UPDATE user SET
              first_name = :first_name, 
              last_name = :last_name,
              email = :email,
              phone = :phone,
              avatar_path = :avatar_path  
              WHERE id = :user_id";
		$statement = $this->connection->prepare($query);
		$statement->execute([
			':first_name' => $user->getFirstName(),
			':last_name' => $user->getLastName(),
			':email' => $user->getEmail(),
			':phone' => $user->getPhone(),
			':avatar_path' => $user->getAvatarPath(),
			':user_id' => $user->getId()
		]);
	}
}