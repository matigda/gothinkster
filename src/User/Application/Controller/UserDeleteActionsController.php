<?php

declare(strict_types = 1);

namespace User\Application\Controller;

use User\Application\UseCase\Command\GetUserProfileCommand;
use User\Application\UseCase\Command\UnfollowUserCommand;
use User\Application\UseCase\GetUserProfileUseCase;
use User\Application\UseCase\UnfollowUserUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use User\Domain\UserRepositoryInterface;

class UserDeleteActionsController
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var UnfollowUserUseCase
     */
    private $unfollowUserUseCase;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var GetUserProfileUseCase
     */
    private $getUserProfileUseCase;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        UnfollowUserUseCase $unfollowUserUseCase,
        SerializerInterface $serializer,
        GetUserProfileUseCase $getUserProfileUseCase,
        UserRepositoryInterface $userRepository
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->unfollowUserUseCase = $unfollowUserUseCase;
        $this->userRepository = $userRepository;
        $this->serializer = $serializer;
        $this->getUserProfileUseCase = $getUserProfileUseCase;
    }

    public function unfollowUserAction(string $username)
    {
        $userToUnfollow = $this->userRepository->findUserByUsername($username);
        $this->unfollowUserUseCase->execute(new UnfollowUserCommand($this->getUser(), $userToUnfollow));

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
