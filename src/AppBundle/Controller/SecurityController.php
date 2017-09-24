<?php

declare(strict_types = 1);

namespace AppBundle\Controller;

use AppBundle\ReadModel\View\UserProfileView;
use Core\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class SecurityController extends FOSRestController
{
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

        $userTokenView = $this->get('provider.user_token_view')->provide($user);

        return [
            'user' => $userTokenView
        ];
    }
}
