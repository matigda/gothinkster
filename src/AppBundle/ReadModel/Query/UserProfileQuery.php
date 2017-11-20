<?php

declare(strict_types=1);

namespace AppBundle\ReadModel\Query;

use Core\Entity\User;
use AppBundle\ReadModel\View\UserProfileView;

interface UserProfileQuery
{
    public function findByUsernameForGivenUser(string $username, User $user): UserProfileView;
}
