<?php

declare(strict_types=1);

namespace User\Domain;

use SharedKernel\Domain\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function add(User $user);

    public function findUserByUsername(string $username): User;
}
