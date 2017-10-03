<?php

namespace spec\AppBundle\Provider;

use AppBundle\Provider\UserTokenViewProvider;
use AppBundle\ReadModel\View\UserTokenView;
use AppBundle\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserTokenViewProviderSpec extends ObjectBehavior
{
    function let(JWTEncoderInterface $JWTEncoder)
    {
        $this->beConstructedWith($JWTEncoder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserTokenViewProvider::class);
    }

    function it_returns_user_token_view_based_on_given_user(JWTEncoderInterface $JWTEncoder)
    {
        $token = 'some-token';
        $user = new User('id', 'username', 'email@email.pl', 'password');

        $JWTEncoder->encode(['username' => $user->getEmail()])->willReturn($token);

        $this->provide($user)->shouldBeLike(new UserTokenView(
            $user->getEmail(),
            $token,
            $user->getUsername(),
            $user->getBio(),
            $user->getImage()
        ));
    }
}
