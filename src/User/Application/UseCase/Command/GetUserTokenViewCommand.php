<?php

declare(strict_types = 1);

namespace User\Application\UseCase\Command;

use User\Application\Entity\User;

final class GetUserTokenViewCommand
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
