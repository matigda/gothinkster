<?php

declare(strict_types=1);

namespace App\UseCase;

use App\ReadModel\Query\UserProfileQuery;
use App\ReadModel\View\UserProfileView;
use App\UseCase\Command\GetUserProfileCommand;

class GetUserProfileUseCase
{
    /**
     * @var UserProfileQuery
     */
    private $userProfileQuery;

    public function __construct(UserProfileQuery $userProfileQuery)
    {
        $this->userProfileQuery = $userProfileQuery;
    }

    public function execute(GetUserProfileCommand $command): UserProfileView
    {
        return $this->userProfileQuery->findByUsernameForGivenUser(
            $command->getUsername(),
            $command->getUserToCheckFollow()
        );
    }
}
