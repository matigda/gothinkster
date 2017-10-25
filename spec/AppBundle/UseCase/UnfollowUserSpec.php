<?php

namespace spec\AppBundle\UseCase;

use AppBundle\UseCase\UnfollowUser;
use Core\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UnfollowUserSpec extends ObjectBehavior
{
    function let(UserRepository $userRepository)
    {
        $this->beConstructedWith($userRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UnfollowUser::class);
    }
}
