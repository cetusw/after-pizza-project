<?php

namespace App\Infrastructure;

class Config
{
	public static function getValidTypes(): array
	{
		return ['image/jpeg', 'image/png', 'image/gif'];
	}

	public static function getValidExtensions(): array
	{
		return ['jpeg', 'png', 'gif'];
	}
}