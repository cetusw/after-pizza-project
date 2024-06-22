<?php
declare(strict_types=1);

namespace App\Controller\Input;

use App\Entity\UserRole;
use App\Service\Input\RegisterUserInputInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterUserInput extends AbstractType implements RegisterUserInputInterface
{
	private string $login;
	private string $email;
	private string $password;
	private ?string $phone;
	private ?string $avatarPath;
	private int $role;

	public function getLogin(): string
	{
		return $this->login;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getPhone(): string
	{
		return $this->phone;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function getAvatarPath(): ?string
	{
		return $this->avatarPath;
	}

	public function getRole(): int
	{
		return $this->role;
	}

	public function setLogin(string $login): ?string
	{
		return $this->login = $login;
	}

	public function setEmail(string $email): ?string
	{
		return $this->email = $email;
	}

	public function setPhone(?string $phone): ?string
	{
		return $this->phone = $phone;
	}

	public function setPassword(string $password): ?string
	{
		return $this->password = $password;
	}

	public function setAvatarPath(?string $avatarPath): ?string
	{
		return $this->avatarPath = $avatarPath;
	}

	public function setRole(int $role): int
	{
		return $this->role = $role;
	}


    public function buildForm(FormBuilderInterface $builder, array $options): void
		{
        $builder->add('login', EmailType::class)
                ->add('email', TextType::class)
                ->add('password', PasswordType::class)
                ->add('avatarPath', TextType::class)
                ->add('role', ChoiceType::class, [
                    'choices'  => [
                        'User' => UserRole::USER,
                        'Admin' => UserRole::ADMIN,
                    ],
                ])
                ->add('register', SubmitType::class);
    }
}
