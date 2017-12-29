<?php

declare(strict_types = 1);

namespace User\Application\Controller;

use User\Application\UseCase\Command\GetUserProfileCommand;
use User\Application\UseCase\Command\GetUserTokenViewCommand;
use User\Application\UseCase\GetUserProfileUseCase;
use User\Application\UseCase\GetUserTokenViewUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserGetActionsController
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

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
        return new JsonResponse(
            $this->serializer->serialize(
                [
                    'user' => $this->getUserTokenViewUseCase->execute(new GetUserTokenViewCommand($this->getUser()))
                ],
                'json'
            ),
            200,
            [],
            true
        );
    }

    public function profileAction(string $username)
    {
        return new JsonResponse(
            $this->serializer->serialize(
                [
                    'profile' => $this->getUserProfileUseCase->execute(
                        new GetUserProfileCommand($username, $this->getUser())
                    ),
                ],
                'json'
            ),
            200,
            [],
            true
        );
    }

    private function getUser()
    {
        $token = $this->tokenStorage->getToken();

        return $token->getUser();
    }
}
