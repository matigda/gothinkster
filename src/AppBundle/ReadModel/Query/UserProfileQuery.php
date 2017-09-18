<?php

declare(strict_types = 1);

namespace AppBundle\ReadModel\Query;

use AppBundle\ReadModel\View\UserProfileView;

interface UserProfileQuery
{
    public function findByUsername(string $username): UserProfileView;
}