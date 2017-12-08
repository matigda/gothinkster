<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Entity\User;
use App\UseCase\Command\RegisterUserCommand;
use Core\Repository\UserRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

final class RegisterUserUseCase
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var PasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserRepositoryInterface $users, PasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $users;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function execute(RegisterUserCommand $command): User
    {
        $user = new User(
            (string) Uuid::uuid4(),
            $command->getUsername(),
            $command->getEmail(),
            $this->passwordEncoder->encodePassword($command->getPassword(), '')
        );

        if ($command->hasBio()) {
            $user->setBio($command->getBio());
        }

        if ($command->hasImage()) {
            $user->setImage($command->getImage());
        }

        $this->userRepository->add($user);

        return $user;
    }
}
