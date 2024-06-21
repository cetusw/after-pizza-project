<?php

namespace App\Model;

use App\Infrastructure\Utils;

class StorefrontTable
{
	public function __construct(private \PDO $connection)
	{
	}

	public function findProductsInDatabase(): array
	{
		try {
			$products = [];
			$query = "SELECT * FROM product";

			$statement = $this->connection->query($query);
			while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
				$products[] = $this->createProductFromRow($row);
			}
			return $products;
		} catch (\PDOException $e) {
			throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
		}
	}

	private function createProductFromRow(array $row): Storefront
	{
		return new Storefront(
			(int)$row['id'],
			$row['name'],
			$row['description'],
			$row['size'],
			$row['price'],
			$row['image_path'] ?? null
		);
	}
}