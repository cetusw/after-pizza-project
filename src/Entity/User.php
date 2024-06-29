<?php

namespace App\Entity;

class User
{
	public function __construct(
		private ?int $id,
		private string $login,
		private string $email,
		private ?string $phone,
		private string $password,
		private int $role,
	)
	{
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getLogin(): string
	{
		return $this->login;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getPhone(): ?string
	{
		return $this->phone;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function getRole(): int
	{
		return $this->role;
	}

	public function setLogin(string $login): string
	{
		return $this->login = $login;
	}

	public function setEmail(string $email): string
	{
		return $this->email = $email;
	}

	public function setPhone(?string $phone): ?string
	{
		return $this->phone = $phone;
	}

	public function setPassword(string $password): string
	{
		return $this->password = $password;
	}

	public function setRole(int $role): int
	{
		return $this->role = $role;
	}
}