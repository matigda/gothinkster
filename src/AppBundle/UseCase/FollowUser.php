<?php

declare(strict_types = 1);

namespace AppBundle\UseCase;

use Core\Repository\UserRepositoryInterface;

final class FollowUser
{
    private $users;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    public function execute(FollowUserCommand $command): void
    {
        $follower = $command->getFollower();
        $follower->follow($command->getFollowed());

        $this->users->save();
    }
}
