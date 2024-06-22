<?php
declare(strict_types=1);

namespace App\Service\Input;

interface RegisterUserInputInterface
{
	  public function getLogin(): string;

    public function getEmail(): string;

    public function getPhone(): string;

    public function getPassword(): string;

 	  public function getAvatarPath(): ?string;

    public function getRole(): int;
}