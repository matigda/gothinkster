<?php

declare(strict_types=1);

namespace AppBundle\UseCase;

use AppBundle\UseCase\Command\FollowUserCommand;
use Core\Repository\UserRepositoryInterface;

final class FollowUserUseCase
{
    /**
     * @var UserRepositoryInterface
     */
    private $usersRepository;

    public function __construct(UserRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function execute(FollowUserCommand $command): void
    {
        $follower = $command->getFollower();
        $follower->follow($command->getFollowed());

        $this->usersRepository->save();
    }
}
