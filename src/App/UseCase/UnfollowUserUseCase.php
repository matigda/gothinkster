<?php

namespace App\UseCase;

use App\UseCase\Command\UnfollowUserCommand;
use Core\Repository\UserRepositoryInterface;

final class UnfollowUserUseCase
{
    /**
     * @var UserRepositoryInterface
     */
    private $usersRepository;

    public function __construct(UserRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function execute(UnfollowUserCommand $command): void
    {
        $follower = $command->getFollower();
        $follower->unfollow($command->getFollowed());

        $this->usersRepository->save();
    }
}
