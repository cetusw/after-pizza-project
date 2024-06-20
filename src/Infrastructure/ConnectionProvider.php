<?php

namespace App\Infrastructure;

class ConnectionProvider
{
	public static function connectDatabase(): \PDO
	{
		return new \PDO(Config::getDatabaseDsn(), Config::getDatabaseUser(), Config::getDatabasePassword());
	}
}