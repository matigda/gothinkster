<?php

declare(strict_types = 1);

namespace tests\unit\Core\Entity;

use PHPUnit\Framework\TestCase;
use User\Domain\InvalidEmailException;
use User\Domain\User;

class UserTest extends TestCase
{
    public function testUserThrowsErrorOnInvalidEmail()
    {
        $this->expectException(InvalidEmailException::class);

        new User('id', 'username', 'email@com', 'pass');
    }

    public function testUserThrowsErrorOnUpdateWithInvalidEmail()
    {
        $this->expectException(InvalidEmailException::class);

        $user = new User('id', 'username', 'email@com.pl', 'pass');

        $user->update('improper.email');
    }

    public function testFollowingAndUnfollowing()
    {
        $user = new User('id', 'username', 'email@provider.com', 'pass');

        $follower = new User('otherid', 'otherusername', 'email@provider.pl', 'pass');

        $this->assertEquals(
            $follower->getFollowers()->toArray(),
            []
        );

        $user->follow($follower);

        $this->assertEquals(
            $follower->getFollowers()->toArray(),
            [$user]
        );

        $user->unfollow($follower);

        $this->assertEquals(
            $follower->getFollowers()->toArray(),
            []
        );
    }

    public function testUpdateUser()
    {
        $user = new User('id', 'username', 'email@provider.com', 'pass');

        $user->update(
            $newEmail = 'new-email@provider.pl',
            $newUsername = 'new-username',
            $newPass = 'new-pass',
            $newImage = 'some-image',
            $newBio = 'other-bio'
        );

        $this->assertUserHasUpdatedProperties(
            $user,
            ['email' => $newEmail, 'username' => $newUsername, 'password' => $newPass, 'image' => $newImage, 'bio' => $newBio,]
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
