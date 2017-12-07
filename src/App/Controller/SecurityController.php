<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class SecurityController extends FOSRestController
{
    use HasTokenViewControllerTrait;

    /**
     * @Post("/users/login")
     */
    public function loginAction(Request $request)
    {
        $userData = json_decode($request->getContent(), true)['user'];

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $userData['email']]);

        if (!$user) {
            throw new ResourceNotFoundException();
        }

        $isPasswordValid = $this->get('encoder.password')
            ->isPasswordValid($user->getPassword(), $userData['password'], null);

        if (!$isPasswordValid) {
            throw new BadCredentialsException();
        }

        return $this->provideUserTokenView($user);
    }
}
