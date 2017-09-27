<?php

declare(strict_types = 1);

namespace AppBundle\UseCase;

use AppBundle\UseCase\Command\UserFollowUserCommand;
use Core\Repository\UserRepositoryInterface;

class MakeUserFollowUserUseCase
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UserFollowUserCommand $command)
    {
        $baseUser = $command->getBaseUser();
        $baseUser->follow($command->getUserToFollow());

        $this->userRepository->update($baseUser);
    }
}
