<?php

namespace App\Controller;

use App\Repository\StorefrontRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CartController extends AbstractController
{
	private StorefrontRepository $repository;

	public function __construct(StorefrontRepository $repository)
	{
		$this->repository = $repository;
	}
	public function addProduct(Request $request): RedirectResponse
	{
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		$productId = $request->get('id');
		$quantity = $request->get('quantity', 1);

		if (!isset($_SESSION['cart'])) {
			$_SESSION['cart'] = [];
		}

		if (isset($_SESSION['cart'][$productId])) {
			$_SESSION['cart'][$productId] += $quantity;
		} else {
			$_SESSION['cart'][$productId] = $quantity;
		}

		$referer = $request->headers->get('referer');

		return new RedirectResponse($referer);
	}

	public function showCart(Request $request): Response
	{
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		$products = [];
		foreach ($_SESSION['cart'] as $productId => $quantity) {
			$product = $this->repository->findProductInDatabase($productId);
			if ($product !== null) {
				$products[] = $product;
			}
		}

		return $this->render('show_cart.html.twig', [
			'products' => $products, 'cart' => $_SESSION['cart']
		]);
	}

	public function removeProduct(Request $request): RedirectResponse
	{
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		$quantity = $_SESSION['cart'][$request->get('id')];
		if ($quantity >= 2) {
			$quantity = $quantity - 1;
			$_SESSION['cart'][$request->get('id')] = $quantity;
		} else {
			unset($_SESSION['cart'][$request->get('id')]);
		}

		$referer = $request->headers->get('referer');

		return new RedirectResponse($referer);
	}

	public function removeAllProduct(Request $request): Response
	{
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		unset($_SESSION['cart'][$request->get('id')]);

		return $this->redirectToRoute('show_cart');
	}
}