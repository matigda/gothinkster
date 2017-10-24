<?php
declare(strict_types = 1);

namespace AppBundle\UseCase;

use AppBundle\Entity\User;
use Core\Repository\UserRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

final class RegisterUser
{
    private $users;
    private $passwordEncoder;

    public function __construct(UserRepository $users, PasswordEncoderInterface $passwordEncoder)
    {
        $this->users = $users;
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

        $this->users->add($user);

        return $user;
    }
}
