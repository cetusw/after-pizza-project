<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\UserRole;
use App\Repository\UserRepository;
use App\Service\Input\RegisterUserInputInterface;

class UserService
{
    public function __construct(
        private UserRepository $repository,
        private PasswordHasher $passwordHasher)
    {
    }

    public function register(RegisterUserInputInterface $input): int
    {
        $existingUser = $this->repository->findUserByLogin($input->getLogin());
        if ($existingUser !== null)
        {
            throw new \InvalidArgumentException("User with email " . $input->getEmail() . " already has been registered");
        }
        if (!UserRole::isValid($input->getRole()))
        {
            throw new \InvalidArgumentException("Role is not valid " . $input->getRole());
        }

        $user = new User(
            null,
						$input->getLogin(),
            $input->getEmail(),
						$input->getPhone(),
            $this->passwordHasher->hash($input->getPassword()),
						$input->getAvatarPath(),
            $input->getRole(),
        );
        return $this->repository->saveUserToDatabase($user);
    }
}