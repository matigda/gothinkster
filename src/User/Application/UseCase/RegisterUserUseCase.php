<?php

declare(strict_types=1);

namespace User\Application\UseCase;

use User\Application\Entity\User;
use User\Application\UseCase\Command\RegisterUserCommand;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use User\Domain\UserRepositoryInterface;

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

    public function __construct(UserRepositoryInterface $userRepository, PasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
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
