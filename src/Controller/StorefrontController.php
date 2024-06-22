<?php

namespace App\Controller;

use App\Repository\StorefrontRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StorefrontController extends AbstractController
{
	private StorefrontRepository $repository;
	private UserRepository $userRepository;

	public function __construct(StorefrontRepository $repository, UserRepository $userRepository)
	{
		$this->repository = $repository;
		$this->userRepository = $userRepository;
	}

	public function showStorefront(): Response
	{
		$user = $this->userRepository->getCurrentUser();
		$products = $this->repository->findProductsInDatabase();
		if ($products === []) {
			throw new \RuntimeException('Storefront Not Found');
		} else {
			return $this->render('show_storefront.html.twig', [
				'products' => $products, 'user' => $user
			]);
		}
	}

	public function createProduct(Request $request): Response
	{

	}


}