<?php

namespace User\Application\UseCase;

use User\Application\UseCase\Command\UnfollowUserCommand;
use User\Domain\UserRepositoryInterface;

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
