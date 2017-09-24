<?php
declare(strict_types = 1);

namespace AppBundle\JWT;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class InMemoryEncoder implements JWTEncoderInterface
{
    /**
     * {@inheritdoc}
     */
    public function encode(array $data)
    {
        return 'jwt.token.here';
    }

    /**
     * {@inheritdoc}
     */
    public function decode($token)
    {
        // TODO: Implement decode() method.
    }
}
