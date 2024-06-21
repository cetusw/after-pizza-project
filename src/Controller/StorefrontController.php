<?php

namespace App\Controller;

use App\Infrastructure\ConnectionProvider;
use App\Model\StorefrontTable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StorefrontController extends AbstractController
{
	private StorefrontTable $table;

	public function __construct()
	{
		$connection = ConnectionProvider::connectDatabase();
		$this->table = new StorefrontTable($connection);
	}

	public function showStorefront(): Response
	{
		$products = $this->table->findProductsInDatabase();
		if ($products === []) {
			throw new \RuntimeException('Storefront Not Found');
		} else {
			return $this->render('show_storefront.html.twig', [
				'products' => $products,
			]);
		}
	}


}