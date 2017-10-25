<?php

namespace AppBundle\UseCase;

use Core\Repository\UserRepository;

final class UnfollowUser
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function execute(UnfollowUserCommand $command): void
    {
        $follower = $command->getFollower();
        $follower->unfollow($command->getFollowed());

        $this->users->update($follower);
    }
}
