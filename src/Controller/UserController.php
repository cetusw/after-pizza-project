<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
	private UserRepository $repository;

	public function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}

	public function index(): Response
	{
		return $this->render('register_user_form.html.twig');
	}

	public function registerUser(Request $request): Response
	{
		$user = new User(
			null,
			$request->get('login'),
			$request->get('email'),
			$request->get('phone'),
			$request->get('password'),
			0,
		);

		$userId = $this->repository->saveUserToDatabase($user);

		return $this->redirectToRoute('show_storefront');
	}

	public function loginUser(Request $request): Response
	{
		return $this->render('login_user_form.html.twig');
	}

	public function authenticateUser(Request $request): Response
	{
		$login = $request->get('login');
		$password = $request->get('password');

		$user = $this->repository->findUserByLogin($login);

		if ($this->repository->checkPassword($user->getId(), $password)) {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			$_SESSION['user_id'] = $user->getId();;
			$_SESSION['login'] = $login;
			$_SESSION['role'] = $user->getRole();
			$_SESSION['cart'] = [];

			return $this->redirectToRoute('show_storefront');
		}	else {
			return $this->redirectToRoute('login_user_form');
		}
	}

	public function logoutUser(Request $request): Response
	{
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		session_destroy();
		return $this->redirectToRoute('login_user');
	}
}