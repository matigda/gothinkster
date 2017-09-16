<?php
declare(strict_types = 1);

namespace Core\Entity;

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
}
