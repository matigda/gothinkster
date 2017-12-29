<?php

declare(strict_types = 1);

namespace tests\unit\User\Application\UseCase;

use User\Application\Entity\User;
use User\Application\UseCase\Command\FollowUserCommand;
use User\Application\UseCase\Command\UnfollowUserCommand;
use User\Application\UseCase\FollowUserUseCase;
use User\Application\UseCase\UnfollowUserUseCase;
use PHPUnit\Framework\TestCase;
use User\Domain\UserRepositoryInterface;

class FollowAndUnfollowUserUseCaseTest extends TestCase
{
    public function testUseCase()
    {
        $followed = $this->getUser();

        $this->assertSame(
            $followed->getFollowers()->toArray(),
            []
        );

        $this->makeUserFollowUser($follower = $this->getUser(), $followed);

        $this->assertSame(
            $followed->getFollowers()->toArray(),
            [$follower]
        );

        $this->makeUserUnfollowUser($follower, $followed);

        $this->assertSame(
            $followed->getFollowers()->toArray(),
            []
        );
    }

    private function makeUserFollowUser(User $follower, User $followed)
    {
        $userRepository = $this->prophesize(UserRepositoryInterface::class);
        $userRepository->save()->shouldBeCalled();
        $useCase = new FollowUserUseCase($userRepository->reveal());

        $useCase->execute(new FollowUserCommand($follower, $followed));
    }

    private function makeUserUnfollowUser(User $follower, User $followed)
    {
        $userRepository = $this->prophesize(UserRepositoryInterface::class);
        $userRepository->save()->shouldBeCalled();
        $useCase = new UnfollowUserUseCase($userRepository->reveal());
        $useCase->execute(new UnfollowUserCommand($follower, $followed));
    }

    private function getUser()
    {
        return new User($id = (string) rand(1, 100000000), 'some-muthaf' . $id, $id . 'email@wp.pl', 'pass');
    }
}
