<?php

declare(strict_types = 1);

namespace AppBundle\UseCase\Command;

use Core\Entity\User;

class UserFollowUserCommand
{
    /**
     * @var User
     */
    private $baseUser;

    /**
     * @var User
     */
    private $userToFollow;

    public function __construct(User $baseUser, User $userToFollow)
    {
        $this->baseUser = $baseUser;
        $this->userToFollow = $userToFollow;
    }

    public function getBaseUser(): User
    {
        return $this->baseUser;
    }

    public function getUserToFollow(): User
    {
        return $this->userToFollow;
    }
}
