<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Infrastructure\Config;

class UserController extends AbstractController
{
	private UserRepository $repository;

	private UserService $service;

	public function __construct(UserService $service, UserRepository $repository)
	{
		$this->service = $service;
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
			$request->get('avatar_path'),
			0,
		);

		$userId = $this->repository->saveUserToDatabase($user);
		$this->saveAvatar($userId);

		return $this->redirectToRoute('show_storefront');
	}

	public function loginUser(Request $request): Response
	{
		return $this->render('login_user_form.html.twig');
	}

	private function saveAvatar(int $userId): bool
	{
		$avatarPath = $_FILES['avatar_path'] ?? null;
		if ($avatarPath === null || $avatarPath['error'] !== UPLOAD_ERR_OK) {
			return false;
		}
		$fileName = $_FILES['avatar_path']['tmp_name'];
		$fileType = mime_content_type($fileName);
		if (!in_array($fileType, Config::getValidTypes())) {
			throw new \RuntimeException('Invalid file type');
		}
		$newFileName = $userId . "." . pathinfo($fileName, PATHINFO_EXTENSION);
		$newPath = './uploads/' . $newFileName;
		if (!move_uploaded_file($_FILES['avatar_path']['tmp_name'], $newPath)) {
			throw new \RuntimeException('Failed to move uploaded file');
		}
		$this->repository->addPathToDatabase($userId, $newPath);
		return true;
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