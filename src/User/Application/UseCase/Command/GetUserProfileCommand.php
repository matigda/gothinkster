<?php

declare(strict_types=1);

namespace User\Application\UseCase\Command;

use User\Domain\User;

final class GetUserProfileCommand
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
