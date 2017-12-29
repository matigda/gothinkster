<?php

declare(strict_types=1);

namespace User\Application\UseCase;

use User\Application\UseCase\Command\FollowUserCommand;
use User\Domain\UserRepositoryInterface;

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
