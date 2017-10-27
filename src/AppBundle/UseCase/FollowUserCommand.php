<?php

declare(strict_types = 1);

namespace AppBundle\UseCase;

use Core\Entity\User;

final class FollowUserCommand
{
    private $follower;
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
