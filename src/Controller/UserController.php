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
		$hashedPassword = password_hash($request->request->get('password'), PASSWORD_DEFAULT);
		$user = new User(
			null,
			$request->get('login'),
			$request->get('email'),
			$request->get('phone'),
			$hashedPassword,
			0,
		);

		$userId = $this->repository->saveUserToDatabase($user);

		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		$_SESSION['user_id'] = $userId;
		$_SESSION['cart'] = [];

		return $this->redirectToRoute('show_storefront');
	}

	public function loginUser(): Response
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
		}

		return $this->redirectToRoute('login_user_form');
	}

	public function logoutUser(): Response
	{
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		session_destroy();
		return $this->redirectToRoute('login_user');
	}
}