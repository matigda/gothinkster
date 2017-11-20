<?php

namespace AppBundle\Provider;

use AppBundle\ReadModel\View\UserTokenView;
use AppBundle\Entity\User;
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

    public function provide(User $user): UserTokenView
    {
        $token = $this->JWTEncoder->encode([
            'username' => $user->getEmail(),
        ]);

        return new UserTokenView($user->getEmail(), $token, $user->getUsername(), $user->getBio(), $user->getImage());
    }
}
