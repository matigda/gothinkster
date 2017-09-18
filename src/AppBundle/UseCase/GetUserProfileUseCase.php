<?php

declare(strict_types = 1);

namespace AppBundle\UseCase;

use AppBundle\ReadModel\Query\UserProfileQuery;
use AppBundle\ReadModel\View\UserProfileView;
use AppBundle\UseCase\Command\GetUserProfileCommand;

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
        return $this->userProfileQuery->findByUsername($command->getUsername());
    }
}