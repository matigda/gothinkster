<?php

namespace AppBundle\Provider;

use AppBundle\ReadModel\View\UserProfileView;
use Core\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class UserTokenViewProvider
{
    /**
     * @var JWTEncoderInterface
     */
    private $JWTEncoder;

    public function __construct(JWTEncoderInterface $JWTEncoder)
    {
        $this->JWTEncoder = $JWTEncoder;
    }

    public function provide(User $user): UserProfileView
    {
    }
}
