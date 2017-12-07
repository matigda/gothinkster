<?php

declare(strict_types=1);

namespace App\Entity;

use Core\Entity\User as BaseUser;
use Symfony\Component\Security\Core\User\UserInterface;

class User extends BaseUser implements UserInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function getFollowers()
    {
        return $this->followers;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }
}
