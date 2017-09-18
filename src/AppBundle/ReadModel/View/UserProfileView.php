<?php

declare(strict_types = 1);

namespace AppBundle\ReadModel\View;

class UserProfileView
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $bio;

    /**
     * @var string
     */
    private $image;

    /**
     * @var bool
     */
    private $following;

    public function __construct(string $username, string $bio, string $image, bool $following)
    {
        $this->username = $username;
        $this->bio = $bio;
        $this->image = $image;
        $this->following = $following;
    }
}