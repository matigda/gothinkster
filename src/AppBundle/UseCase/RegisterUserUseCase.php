<?php
declare(strict_types = 1);

namespace AppBundle\UseCase;

use Core\Entity\User;
use Core\Repository\UserRepositoryInterface;
use AppBundle\UseCase\Command\RegisterUserCommand;
use Ramsey\Uuid\Uuid;

class RegisterUserUseCase
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(RegisterUserCommand $command): User
    {
        $user = new User((string) Uuid::uuid4(), $command->getUsername(), $command->getEmail(), $command->getPassword());

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
