<?php

namespace spec\AppBundle\UseCase;

use AppBundle\UseCase\UnfollowUser;
use Core\Repository\UserRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UnfollowUserSpec extends ObjectBehavior
{
    function let(UserRepositoryInterface $userRepository)
    {
        $this->beConstructedWith($userRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UnfollowUser::class);
    }
}
