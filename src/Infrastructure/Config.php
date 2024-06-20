<?php

namespace App\Infrastructure;

class Config
{
	public static function getDatabaseDsn(): string
	{
		return 'mysql:host=localhost;dbname=after_pizza';
	}
	public static function getDatabaseUser(): string
	{
		return 'yogurt';
	}
	public static function getDatabasePassword(): string
	{
		return 'pAssw0rd#';
	}

	public static function getValidTypes(): array
	{
		return ['image/jpeg', 'image/png', 'image/gif'];
	}

	public static function getValidExtensions(): array
	{
		return ['jpeg', 'png', 'gif'];
	}
}