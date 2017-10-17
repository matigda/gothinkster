<?php

declare(strict_types = 1);

namespace AppBundle\UseCase\Command;

use Core\Entity\User;

class GetUserProfileCommand
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var User
     */
    private $userToCheckFollow;

    public function __construct(string $username, User $userToCheckFollow)
    {
        $this->username = $username;
        $this->userToCheckFollow = $userToCheckFollow;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getUserToCheckFollow(): User
    {
        return $this->userToCheckFollow;
    }
}
