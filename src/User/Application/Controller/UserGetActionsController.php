<?php

declare(strict_types = 1);

namespace User\Application\Controller;

use SharedKernel\Application\JsonResponseTrait;
use SharedKernel\Application\UserAwareTrait;
use User\Application\UseCase\Command\GetUserProfileCommand;
use User\Application\UseCase\Command\GetUserTokenViewCommand;
use User\Application\UseCase\GetUserProfileUseCase;
use User\Application\UseCase\GetUserTokenViewUseCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserGetActionsController
{
    use JsonResponseTrait, UserAwareTrait;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var GetUserProfileUseCase
     */
    private $getUserProfileUseCase;

    /**
     * @var GetUserTokenViewUseCase
     */
    private $getUserTokenViewUseCase;

    public function __construct(
        GetUserProfileUseCase $getUserProfileUseCase,
        GetUserTokenViewUseCase $getUserTokenViewUseCase,
        TokenStorageInterface $tokenStorage,
        SerializerInterface $serializer
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->serializer = $serializer;
        $this->getUserProfileUseCase = $getUserProfileUseCase;
        $this->getUserTokenViewUseCase = $getUserTokenViewUseCase;
    }

    public function userTokenViewAction()
    {
        return $this->returnJsonResponse([
            'user' => $this->getUserTokenViewUseCase->execute(new GetUserTokenViewCommand($this->getUser()))
        ]);
    }

    public function profileAction(string $username)
    {
        return $this->returnJsonResponse([
            'profile' => $this->getUserProfileUseCase->execute(
                new GetUserProfileCommand($username, $this->getUser())
            ),
        ]);
    }
}
