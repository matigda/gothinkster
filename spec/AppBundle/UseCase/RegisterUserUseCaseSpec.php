<?php

namespace spec\AppBundle\UseCase;

use AppBundle\Entity\User;
use AppBundle\UseCase\RegisterUserCommand;
use AppBundle\UseCase\RegisterUser;
use Core\Repository\UserRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class RegisterUserSpec extends ObjectBehavior
{
    function let(UserRepositoryInterface $userRepository, PasswordEncoderInterface $passwordEncoder)
    {
        $this->beConstructedWith($userRepository, $passwordEncoder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RegisterUser::class);
    }

    function it_creates_user_and_adds_to_repository(UserRepositoryInterface $userRepository, PasswordEncoderInterface $passwordEncoder)
    {
        $passwordEncoder->encodePassword($password = 'pass', null)->willReturn($encodedPass = 'encodedpass');

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
