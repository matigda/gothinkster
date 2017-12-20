<?php

declare(strict_types = 1);

namespace tests\unit\App\UseCase;

use App\Entity\User;
use App\UseCase\Command\FollowUserCommand;
use App\UseCase\Command\UnfollowUserCommand;
use App\UseCase\FollowUserUseCase;
use App\UseCase\UnfollowUserUseCase;
use Core\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

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
