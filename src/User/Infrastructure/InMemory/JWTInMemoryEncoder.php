<?php

declare(strict_types=1);

namespace User\Infrastructure\InMemory;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class JWTInMemoryEncoder implements JWTEncoderInterface
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
        return [
          'username' => $token,
        ];
    }
}
