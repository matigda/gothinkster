<?php
declare(strict_types = 1);

namespace AppBundle\UseCase;

use AppBundle\Entity\User;
use Core\Repository\UserRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

final class RegisterUser
{
    private $userRepository;
    private $passwordEncoder;

    public function __construct(UserRepositoryInterface $users, PasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $users;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function execute(RegisterUserCommand $command): User
    {
        $user = new User(
            Uuid::uuid4()->toString(),
            $command->getUsername(),
            $command->getEmail(),
            $this->passwordEncoder->encodePassword($command->getPassword(), null)
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
