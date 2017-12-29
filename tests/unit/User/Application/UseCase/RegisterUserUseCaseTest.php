<?php

declare(strict_types = 1);

namespace tests\unit\User\Application\UseCase;

use User\Application\Entity\User;
use User\Application\UseCase\Command\RegisterUserCommand;
use User\Application\UseCase\RegisterUserUseCase;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use User\Domain\UserRepositoryInterface;

class RegisterUserUseCaseTest extends TestCase
{
    public function testUseCase()
    {
        $user = $this->registerUser();

        $this->assertUseCaseCreatedUserWithProperProperties($user);
    }

    private function registerUser()
    {
        $userRepository = $this->prophesize(UserRepositoryInterface::class);
        $passwordEncoder = $this->prophesize(PasswordEncoderInterface::class);
        $userRepository->add(Argument::type(User::class))->shouldBeCalled();
        $passwordEncoder->encodePassword('password', '')->willReturn('hashed password');

        $useCase = new RegisterUserUseCase($userRepository->reveal(), $passwordEncoder->reveal());

        return $useCase->execute(new RegisterUserCommand('username', 'email@wp.pl', 'password', 'bio', 'image'));
    }

    private function assertUseCaseCreatedUserWithProperProperties(User $user)
    {
        $this->assertEquals(
            $user->getUsername(),
            'username'
        );

        $this->assertEquals(
            $user->getEmail(),
            'email@wp.pl'
        );

        $this->assertEquals(
            $user->getPassword(),
            'hashed password'
        );

        $this->assertEquals(
            $user->getBio(),
            'bio'
        );

        $this->assertEquals(
            $user->getImage(),
            'image'
        );
    }
}
