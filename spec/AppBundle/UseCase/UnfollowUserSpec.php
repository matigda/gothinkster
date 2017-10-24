<?php

namespace spec\AppBundle\UseCase;

use AppBundle\UseCase\UnfollowUser;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UnfollowUserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UnfollowUser::class);
    }
}
