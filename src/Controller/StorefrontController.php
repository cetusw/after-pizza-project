<?php

namespace App\Controller;

use App\Entity\Storefront;
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

		return $this->render('show_storefront.html.twig', [
			'products' => $products, 'user' => $user, 'cart' => $_SESSION['cart']
		]);

	}

	public function createProductForm(Request $request): Response
	{
		return $this->render('create_product_form.html.twig');
	}

	public function createProduct(Request $request): Response
	{
		$product = new Storefront(
			null,
			$request->get('name'),
		  $request->get('description'),
			$request->get('size'),
			$request->get('price'),
			$request->get('image_path'),
		);

		$productId = $this->repository->saveProductToDatabase($product);

		return $this->redirectToRoute('show_product', ['id' => $productId]);
	}

	public function showProduct(): Response
	{
		$user = $this->userRepository->getCurrentUser();
		$product = $this->repository->findProductInDatabase($_GET['id']);
		if ($product === null) {
			throw new \RuntimeException('Product Not Found');
		} else {
			return $this->render('show_product.html.twig', [
				'product' => $product, 'user' => $user
			]);
		}
	}

	public function deleteProduct(Request $request): Response
	{
		$product = $this->repository->findProductInDatabase($_GET['id']);
		if ($product === null) {
			throw new \RuntimeException('Product Not Found');
		}
		$this->repository->deleteProductFromDatabase($product);
		return $this->redirectToRoute('show_storefront');
	}

}