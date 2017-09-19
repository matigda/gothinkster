<?php
declare(strict_types = 1);

namespace Core\Entity;

use Core\Exception\InvalidEmailException;

class User
{
    /**
     * @var string
     */
    private $id;

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

    public function __construct(string $id, string $username, string $email, string $password)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException($email);
        }
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function setBio(string $bio)
    {
        $this->bio = $bio;
    }

    public function setImage(string $image)
    {
        $this->image = $image;
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

    public function getBio()
    {
        return $this->bio;
    }

    public function getImage()
    {
        return $this->image;
    }
}
