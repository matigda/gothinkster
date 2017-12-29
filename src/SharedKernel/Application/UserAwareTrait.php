<?php

declare(strict_types = 1);

namespace SharedKernel\Application;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

trait UserAwareTrait
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    private function getUser()
    {
        $token = $this->tokenStorage->getToken();

        return $token->getUser();
    }
}
