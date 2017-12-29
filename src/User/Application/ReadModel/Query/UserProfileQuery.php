<?php

declare(strict_types=1);

namespace User\Application\ReadModel\Query;

use User\Application\ReadModel\View\UserProfileView;
use User\Domain\User;

interface UserProfileQuery
{
    public function findByUsernameForGivenUser(string $username, User $user): UserProfileView;
}
