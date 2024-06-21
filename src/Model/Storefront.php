<?php

namespace App\Model;

class Storefront
{
	public function __construct(
		private ?int $id,
		private string $name,
		private string $description,
		private ?string $size,
		private string $price,
		private ?string $imagePath,
	)
	{
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getDescription(): string
	{
		return $this->description;
	}

	public function getSize(): string
	{
		return $this->size;
	}

	public function getPrice(): ?string
	{
		return $this->price;
	}

	public function getImagePath(): ?string
	{
		return $this->imagePath;
	}

	public function setName(string $name): ?string
	{
		return $this->name = $name;
	}

	public function setDescription(string $description): ?string
	{
		return $this->description = $description;
	}

	public function setSize(string $size): ?string
	{
		return $this->size = $size;
	}

	public function setPrice(string $price): ?string
	{
		return $this->price = $price;
	}

	public function setImagePath(string $imagePath): ?string
	{
		return $this->imagePath = $imagePath;
	}
}