<?php

declare(strict_types=1);

namespace Core\Entity;

use Core\Exception\InvalidEmailException;
use Doctrine\Common\Collections\ArrayCollection;

class User
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string|null
     */
    protected $bio;

    /**
     * @var string|null
     */
    protected $image;

    /**
     * @var ArrayCollection<User>
     */
    protected $followers;

    public function __construct(string $id, string $username, string $email, string $password)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException($email);
        }
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;

        $this->followers = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function unfollow(self $user)
    {
        if ($user->followers->exists(function ($key, User $existingFollower) {
            return $this->email == $existingFollower->email;
        })) {
            $user->followers->removeElement($this);
        }
    }

    public function follow(self $user)
    {
        if (!$user->followers->exists(function ($key, User $existingFollower) {
            return $this->email == $existingFollower->email;
        })) {
            $user->followers->add($this);
        }
    }

    public function getFollowers()
    {
        return $this->followers;
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
