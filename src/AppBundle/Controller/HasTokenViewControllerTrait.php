<?php

declare(strict_types = 1);

namespace AppBundle\Controller;

use AppBundle\Provider\UserTokenViewProvider;
use Core\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

trait HasTokenViewControllerTrait
{
    use ContainerAwareTrait;

    protected function provideUserTokenView(User $user): array
    {
        $userTokenView = $this->container->get(UserTokenViewProvider::class)->provide($user);

        return [
            'user' => $userTokenView
        ];
    }
}
