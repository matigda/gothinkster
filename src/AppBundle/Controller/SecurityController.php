<?php

declare(strict_types = 1);

namespace AppBundle\Controller;

use Core\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class SecurityController extends Controller
{
    /**
     * @Route("/api/users/login", name="login")
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

        $token = $this->get('lexik_jwt_authentication.encoder')->encode([
            'username' => $userData['email']
        ]);

        dump($this->get('lexik_jwt_authentication.encoder')->decode($token));

//        dump($token);;
    }
}