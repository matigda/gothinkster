<?php

namespace spec\App\UseCase;

use App\Entity\User;
use App\UseCase\Command\RegisterUserCommand;
use App\UseCase\RegisterUserUseCase;
use Core\Repository\UserRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class RegisterUserUseCaseSpec extends ObjectBehavior
{
    function let(UserRepositoryInterface $userRepository, PasswordEncoderInterface $passwordEncoder)
    {
        $this->beConstructedWith($userRepository, $passwordEncoder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RegisterUserUseCase::class);
    }

    function it_creates_user_and_adds_to_repository(UserRepositoryInterface $userRepository, PasswordEncoderInterface $passwordEncoder)
    {
        $passwordEncoder->encodePassword($password = 'pass', '')->willReturn($encodedPass = 'encodedpass');

        $userRepository->add(Argument::type(User::class));

        $result = $this->execute(
            new RegisterUserCommand(
                $username = 'username',
                $email = 'email@email.com',
                $password
            )
        );

        $result->shouldBeAnInstanceOf(User::class);
        $result->getUsername()->shouldBe($username);
        $result->getEmail()->shouldBe($email);
        $result->getPassword()->shouldBe($encodedPass);
    }
}
