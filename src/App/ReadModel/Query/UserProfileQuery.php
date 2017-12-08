<?php

declare(strict_types=1);

namespace App\ReadModel\Query;

use Core\Entity\User;
use App\ReadModel\View\UserProfileView;

interface UserProfileQuery
{
    public function findByUsernameForGivenUser(string $username, User $user): UserProfileView;
}
