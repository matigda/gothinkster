<?php

declare(strict_types = 1);

namespace AppBundle\ReadModel\View;

class UserTokenView
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string|null
     */
    private $bio;

    /**
     * @var string|null
     */
    private $image;

    public function __construct(string $email, string $token, string $username, string $bio = null, string $image = null)
    {
        $this->email = $email;
        $this->token = $token;
        $this->username = $username;
        $this->bio = $bio;
        $this->image = $image;
    }
}