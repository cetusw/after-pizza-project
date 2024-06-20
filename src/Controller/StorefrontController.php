<?php

namespace App\Controller;

use App\Infrastructure\ConnectionProvider;
use App\Model\StorefrontTable;
use Symfony\Component\HttpFoundation\Response;

class StorefrontController
{
	/*private StorefrontTable $table;

	public function __construct()
	{
		$connection = ConnectionProvider::connectDatabase();
		$this->table = new StorefrontTable($connection);
	}*/

	public function showStorefront(): Response
	{
		$contents = PhpTemplateEngine::render('storefront.php');
		return new Response($contents);
	}
}