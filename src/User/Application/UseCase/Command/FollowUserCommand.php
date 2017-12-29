<?php

declare(strict_types=1);

namespace User\Application\UseCase\Command;

use User\Domain\User;

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
