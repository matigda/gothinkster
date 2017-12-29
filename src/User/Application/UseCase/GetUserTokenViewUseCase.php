<?php

declare(strict_types = 1);

namespace User\Application\UseCase;

use User\Application\ReadModel\View\UserTokenView;
use User\Application\UseCase\Command\GetUserTokenViewCommand;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

final class GetUserTokenViewUseCase
{
    /**
     * @var JWTEncoderInterface
     */
    private $JWTEncoder;

    public function __construct(JWTEncoderInterface $JWTEncoder)
    {
        $this->JWTEncoder = $JWTEncoder;
    }

    public function execute(GetUserTokenViewCommand $command): UserTokenView
    {
        $user = $command->getUser();

        $token = $this->JWTEncoder->encode([
            'username' => $user->getEmail(),
        ]);

        return new UserTokenView($user->getEmail(), $token, $user->getUsername(), $user->getBio(), $user->getImage());
    }
}
