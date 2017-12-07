<?php

declare(strict_types=1);

namespace App\Controller;

use Core\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

trait HasTokenViewControllerTrait
{
    use ContainerAwareTrait;

    protected function provideUserTokenView(User $user): array
    {
        $userTokenView = $this->container->get('provider.user_token_view')->provide($user);

        return [
            'user' => $userTokenView,
        ];
    }
}
