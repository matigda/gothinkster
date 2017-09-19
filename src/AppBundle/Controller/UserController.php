<?php

namespace AppBundle\Controller;

use AppBundle\UseCase\Command\RegisterUserCommand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/api/users", name="user_register")
     * @Method("POST")
     */
    public function registerAction(Request $request)
    {
        $userData = json_decode($request->getContent(), true)['user'];

        $user = $this->get('use_case.register_user')->execute(
            new RegisterUserCommand(
                $userData['username'],
                $userData['email'],
                $userData['password'],
                $userData['bio'],
                $userData['image']
            )
        );

        return new Response('', 201);
    }

    /**
     * @Route("/api/profiles/{username}", name="user_profile")
     */
    public function profileAction()
    {

    }
}
