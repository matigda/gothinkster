<?php

declare(strict_types = 1);

namespace tests\unit\User\Application\UseCase;

use User\Application\UseCase\Command\UpdateUserCommand;
use User\Application\UseCase\UpdateUserUseCase;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use User\Application\Entity\User;
use User\Domain\UserRepositoryInterface;

class UpdateUserUseCaseTest extends TestCase
{
    public function testUpdate()
    {
        $passwordEncoder = $this->prophesize(PasswordEncoderInterface::class);
        $userRepo = $this->prophesize(UserRepositoryInterface::class);
        $passwordEncoder->encodePassword($newPass = 'new-pass', '')->willReturn($encryptedPass = 'encrypted-pass');

        $useCase = new UpdateUserUseCase($passwordEncoder->reveal(), $userRepo->reveal());

        $updatedUser = $useCase->execute(
            new UpdateUserCommand(
                new User('id', 'username', 'email@email.com', 'pass'),
                $newEmail = 'new-email@mail.com',
                '',
                $newPass
            )
        );


        $this->assertUserHasUpdatedProperties(
            $updatedUser,
            ['email' => $newEmail, 'password' => $encryptedPass,]
        );
    }

    private function assertUserHasUpdatedProperties(User $user, array $properties)
    {
        $userReflection = new \ReflectionClass($user);

        foreach ($properties as $propertyName => $value) {
            $property = $userReflection->getProperty($propertyName);
            $property->setAccessible(true);

            $this->assertEquals(
                $property->getValue($user),
                $value
            );
        }
    }
}
