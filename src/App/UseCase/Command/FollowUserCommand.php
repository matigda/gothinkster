<?php

declare(strict_types=1);

namespace App\UseCase\Command;

use Core\Entity\User;

final class FollowUserCommand
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
