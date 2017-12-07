<?php

namespace App\UseCase\Command;

use App\Entity\User;

final class UnfollowUserCommand
{
    /**
     * @var User
     */
    private $follower;

    /**
     * @var User
     */
    private $followed;

    public function __construct(User $follower, User $followed)
    {
        $this->follower = $follower;
        $this->followed = $followed;
    }

    public function getFollower(): User
    {
        return $this->follower;
    }

    public function getFollowed(): User
    {
        return $this->followed;
    }
}
