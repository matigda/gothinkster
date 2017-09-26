<?php

namespace AppBundle\Controller;

use AppBundle\UseCase\Command\RegisterUserCommand;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Post("/users")
     * @Rest\View(statusCode=201)
     */
    public function registerAction(Request $request)
    {
        $userData = json_decode($request->getContent(), true)['user'];

        $user = $this->get('use_case.register_user')->execute(
            new RegisterUserCommand(
                $userData['username'],
                $userData['email'],
                $userData['password'],
                $userData['bio'] ?? null,
                $userData['image'] ?? null
            )
        );

        $userTokenView = $this->get('provider.user_token_view')->provide($user);

        return [
            'user' => $userTokenView
        ];
    }

    /**
     * @Get("/user")
     */
    public function getCurrentUserAction()
    {
        return [];
    }

    /**
     * @Get("/profiles/{username}")
     */
    public function profileAction()
    {

    }
}
