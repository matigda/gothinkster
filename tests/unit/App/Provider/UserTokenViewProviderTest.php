<?php

declare(strict_types = 1);

namespace tests\unit\App\Provider;

use App\Provider\UserTokenViewProvider;
use App\ReadModel\View\UserTokenView;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use PHPUnit\Framework\TestCase;
use App\Entity\User;

class UserTokenViewProviderTest extends TestCase
{
    public function testProvidingUserTokenView()
    {
        $user = new User('id', 'username', 'email@email.pl', 'password');

        $jwt = $this->prophesize(JWTEncoderInterface::class);
        $jwt->encode(['username' => $user->getEmail()])->willReturn($token = 'some-token');

        $provider = new UserTokenViewProvider($jwt->reveal());

        self::assertEquals(
            $provider->provide($user),
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
