<?php
declare(strict_types = 1);

namespace Core\Repository;

use Core\Entity\User;

interface UserRepositoryInterface
{
    public function add(User $user);
}
