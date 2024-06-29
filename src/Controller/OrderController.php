<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
	private OrderRepository $repository;
	private UserRepository $userRepository;

	public function __construct(OrderRepository $repository, UserRepository $userRepository)
	{
		$this->repository = $repository;
		$this->userRepository = $userRepository;
	}
	public function orderForm(Request $request): Response
	{
		return $this->render('make_order_form.html.twig');
	}

	public function orderSubmit(Request $request): Response
	{
		$orderDate = new DateTime();

		$user = $this->userRepository->getCurrentUser();
		$order = new Order(
			null,
			$request->get('customerName'),
			$user->getEmail(),
			$request->get('phone'),
			$request->get('address'),
			$request->get('comments'),
			serialize($_SESSION['cart']),
			$orderDate,
		);

		$orderId = $this->repository->saveOrderToDatabase($order);

		return $this->redirectToRoute('show_order', ['id' => $orderId]);
	}

	public function showOrder(): Response
	{
		$user = $this->userRepository->getCurrentUser();
		$order = $this->repository->findOrderInDatabase($_GET['id']);
		if ($order === null) {
			throw new \RuntimeException('Order Not Found');
		} else {
			return $this->render('show_order.html.twig', [
				'order' => $order, 'user' => $user
			]);
		}
	}
}