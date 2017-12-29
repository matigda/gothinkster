<?php

declare(strict_types = 1);

namespace tests\unit\User\Application\Provider;

use User\Application\ReadModel\View\UserTokenView;
use User\Application\UseCase\Command\GetUserTokenViewCommand;
use User\Application\UseCase\GetUserTokenViewUseCase;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use PHPUnit\Framework\TestCase;
use User\Application\Entity\User;

class GetUserTokenViewUseCaseTest extends TestCase
{
    public function testProvidingUserTokenView()
    {
        $user = new User('id', 'username', 'email@email.pl', 'password');

        $jwt = $this->prophesize(JWTEncoderInterface::class);
        $jwt->encode(['username' => $user->getEmail()])->willReturn($token = 'some-token');

        $useCase = new GetUserTokenViewUseCase($jwt->reveal());

        self::assertEquals(
            $useCase->execute(new GetUserTokenViewCommand($user)),
            new UserTokenView(
                $user->getEmail(),
                $token,
                $user->getUsername(),
                $user->getBio(),
                $user->getImage()
            )
        );
    }
}
