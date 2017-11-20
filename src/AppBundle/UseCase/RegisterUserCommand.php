<?php

declare(strict_types=1);

namespace AppBundle\UseCase;

final class RegisterUserCommand
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string|null
     */
    private $bio;

    /**
     * @var string|null
     */
    private $image;

    public function __construct(
        string $username,
        string $email,
        string $password,
        string $bio = null,
        string $image = null
    ) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->bio = $bio;
        $this->image = $image;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getBio()
    {
        return $this->bio;
    }

    public function hasBio(): bool
    {
        return null !== $this->bio;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function hasImage(): bool
    {
        return null !== $this->image;
    }
}
