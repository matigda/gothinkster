<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\UseCase\Command\GetUserProfileCommand;
use AppBundle\UseCase\Command\RegisterUserCommand;
use AppBundle\UseCase\Command\UserFollowUserCommand;
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
        $userTokenView = $this->get('provider.user_token_view')->provide($this->getUser());

        return [
            'user' => $userTokenView
        ];
    }

    /**
     * @Get("/profiles/{username}")
     */
    public function profileAction(string $username)
    {
        $user = $this->get('use_case.get_user_profile')->execute(new GetUserProfileCommand($username));
    }

    /**
     * @Post("/profiles/{username}/follow")
     */
    public function followUserAction(string $username)
    {
        $userToFollow = $this->getDoctrine()->getRepository(User::class)->findOneBy(compact('username'));
dump($userToFollow);die;
        $this->get('use_case.user_follow_user')->execute(new UserFollowUserCommand($this->getUser(), $userToFollow));
        $this->get('use_case.user_follow_user')->execute(new UserFollowUserCommand($this->getUser(), $userToFollow));
    }
}
