<?php

declare(strict_types = 1);

namespace User\Application\Controller;

use User\Application\UseCase\Command\GetUserTokenViewCommand;
use User\Application\UseCase\Command\UpdateUserCommand;
use User\Application\UseCase\GetUserTokenViewUseCase;
use User\Application\UseCase\UpdateUserUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserPutActionsController
{
    /**
     * @var UpdateUserUseCase
     */
    private $updateUserUseCase;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var GetUserTokenViewUseCase
     */
    private $getUserTokenViewUseCase;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        UpdateUserUseCase $updateUserUseCase,
        GetUserTokenViewUseCase $getUserTokenViewUseCase,
        SerializerInterface $serializer
    ){
        $this->updateUserUseCase = $updateUserUseCase;
        $this->tokenStorage = $tokenStorage;
        $this->getUserTokenViewUseCase = $getUserTokenViewUseCase;
        $this->serializer = $serializer;
    }

    public function updateUserAction(Request $request)
    {
        $userData = json_decode($request->getContent(), true)['user'];

        $user = $this->updateUserUseCase->execute(
            new UpdateUserCommand(
                $this->getUser(),
                $userData['email'] ?? '',
                $userData['username'] ?? '',
                $userData['password'] ?? '',
                $userData['image'] ?? '',
                $userData['bio'] ?? ''
            )
        );

        return new JsonResponse(
            $this->serializer->serialize(
                [
                    'user' => $this->getUserTokenViewUseCase->execute(new GetUserTokenViewCommand($user))
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
