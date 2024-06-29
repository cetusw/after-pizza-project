<?php

namespace App\Entity;

class Order
{
	public function __construct(
		private ?int $orderId,
		private string $customerName,
		private string $email,
		private string $phone,
		private string $address,
		private ?string $comments,
		private string $products,
		private \DateTime $orderDate,
	)
	{
	}

	public function getOrderId(): ?int
	{
		return $this->orderId;
	}

	public function getCustomerName(): string
	{
		return $this->customerName;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getPhone(): ?string
	{
		return $this->phone;
	}

	public function getAddress(): string
	{
		return $this->address;
	}

	public function getComments(): string
	{
		return $this->comments;
	}

	public function getProducts(): string
	{
		return $this->products;
	}

	public function getOrderDate(): \DateTime
	{
		return $this->orderDate;
	}

	public function setOrderDate(\DateTime $orderDate): void
	{
		$this->orderDate = $orderDate;
	}

	public function setCustomerName(string $customerName): void
	{
		$this->customerName = $customerName;
	}

	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

	public function setPhone(?string $phone): void
	{
		$this->phone = $phone;
	}

	public function setAddress(string $address): void
	{
		$this->address = $address;
	}

	public function setComments(string $comments): void
	{
		$this->comments = $comments;
	}

	public function setProducts(string $products): void
	{
		$this->products = $products;
	}
}