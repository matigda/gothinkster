<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Entity\User;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function add(User $user);
}
