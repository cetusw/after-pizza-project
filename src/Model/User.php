<?php

namespace App\Model;

class User
{
	public function __construct(
		private ?int $id,
		private string $firstName,
		private string $lastName,
		private string $email,
		private ?string $phone,
		private ?string $avatarPath
	)
	{
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getFirstName(): string
	{
		return $this->firstName;
	}

	public function getLastName(): string
	{
		return $this->lastName;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getPhone(): ?string
	{
		return $this->phone;
	}

	public function getAvatarPath(): ?string
	{
		return $this->avatarPath;
	}

	public function setFirstName(string $firstName): ?string
	{
		return $this->firstName = $firstName;
	}

	public function setLastName(string $lastName): ?string
	{
		return $this->lastName = $lastName;
	}

	public function setEmail(string $email): ?string
	{
		return $this->email = $email;
	}

	public function setPhone(?string $phone): ?string
	{
		return $this->phone = $phone;
	}

	public function setAvatarPath(?string $avatarPath): ?string
	{
		return $this->avatarPath = $avatarPath;
	}
}