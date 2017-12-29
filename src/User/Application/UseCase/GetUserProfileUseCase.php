<?php

declare(strict_types=1);

namespace User\Application\UseCase;

use User\Application\ReadModel\Query\UserProfileQuery;
use User\Application\ReadModel\View\UserProfileView;
use User\Application\UseCase\Command\GetUserProfileCommand;

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
