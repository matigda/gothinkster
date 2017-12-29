<?php

declare(strict_types = 1);

namespace User\Application\Controller;

use User\Application\UseCase\Command\FollowUserCommand;
use User\Application\UseCase\Command\GetUserProfileCommand;
use User\Application\UseCase\Command\GetUserTokenViewCommand;
use User\Application\UseCase\Command\RegisterUserCommand;
use User\Application\UseCase\FollowUserUseCase;
use User\Application\UseCase\GetUserProfileUseCase;
use User\Application\UseCase\GetUserTokenViewUseCase;
use User\Application\UseCase\RegisterUserUseCase;
use User\Infrastructure\Doctrine\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Serializer\SerializerInterface;

class UserPostActionsController
{
    /**
     * @var RegisterUserUseCase
     */
    private $registerUserUseCase;

    /**
     * @var GetUserTokenViewUseCase
     */
    private $getUserTokenViewUseCase;

    /**
     * @var FollowUserUseCase
     */
    private $followUserUseCase;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var GetUserProfileUseCase
     */
    private $getUserProfileUseCase;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(
        RegisterUserUseCase $registerUserUseCase,
        GetUserTokenViewUseCase $getUserTokenViewUseCase,
        FollowUserUseCase $followUserUseCase,
        GetUserProfileUseCase $getUserProfileUseCase,
        TokenStorageInterface $tokenStorage,
        UserRepository $userRepository,
        SerializerInterface $serializer,
        PasswordEncoderInterface $passwordEncoder
    ) {
        $this->registerUserUseCase = $registerUserUseCase;
        $this->getUserTokenViewUseCase = $getUserTokenViewUseCase;
        $this->followUserUseCase = $followUserUseCase;
        $this->serializer = $serializer;
        $this->getUserProfileUseCase = $getUserProfileUseCase;
        $this->tokenStorage = $tokenStorage;
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function registerAction(Request $request)
    {
        $userData = json_decode($request->getContent(), true)['user'];

        $user = $this->registerUserUseCase->execute(
            new RegisterUserCommand(
                $userData['username'],
                $userData['email'],
                $userData['password'],
                $userData['bio'] ?? null,
                $userData['image'] ?? null
            )
        );

        return new JsonResponse(
            $this->serializer->serialize(
                [
                    'user' => $this->getUserTokenViewUseCase->execute(new GetUserTokenViewCommand($user))
                ],
                'json'
            ),
            201,
            [],
            true
        );
    }

    public function followUserAction(string $username)
    {
        $userToFollow = $this->userRepository->findUserByUsername($username);
        $this->followUserUseCase->execute(new FollowUserCommand($this->getUser(), $userToFollow));

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

    public function loginAction(Request $request)
    {
        $userData = json_decode($request->getContent(), true)['user'];

        $user = $this->userRepository->findUserByEmail($userData['email']);

        if (!$user) {
            throw new ResourceNotFoundException();
        }

        $isPasswordValid = $this->passwordEncoder
            ->isPasswordValid($user->getPassword(), $userData['password'], null);

        if (!$isPasswordValid) {
            throw new BadCredentialsException();
        }

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
