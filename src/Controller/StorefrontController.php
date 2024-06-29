<?php

namespace App\Controller;

use App\Entity\Storefront;
use App\Infrastructure\Config;
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
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

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
		$newImage = $this->saveImage();

		$product = new Storefront(
			null,
			$request->get('name'),
		  $request->get('description'),
			$request->get('size'),
			$request->get('price'),
			$newImage,
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

	private function saveImage(): string
	{
		$imagePath = $_FILES['imagePath'] ?? null;
		if ($imagePath === null || $imagePath['error'] !== UPLOAD_ERR_OK) {
			return 'placeholder.png';
		}
		$fileName = $_FILES['imagePath']['tmp_name'];
		$fileType = mime_content_type($fileName);
		if (!in_array($fileType, Config::getValidTypes())) {
			throw new \RuntimeException('Invalid file type');
		}
		$newFileName = uniqid('product_', true) . "." . pathinfo($fileName, PATHINFO_EXTENSION);
		$newPath = 'uploads/' . $newFileName;
		if (!move_uploaded_file($_FILES['imagePath']['tmp_name'], $newPath)) {
			throw new \RuntimeException('Failed to move uploaded file');
		}
		return $newFileName;
	}

}