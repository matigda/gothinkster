<?php

namespace spec\App\UseCase;

use App\UseCase\UnfollowUserUseCase;
use Core\Repository\UserRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UnfollowUserUseCaseSpec extends ObjectBehavior
{
    function let(UserRepositoryInterface $userRepository)
    {
        $this->beConstructedWith($userRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UnfollowUserUseCase::class);
    }
}
