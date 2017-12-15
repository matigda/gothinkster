<?php

namespace App\Controller;

use App\Entity\User;
use App\UseCase\Command\FollowUserCommand;
use App\UseCase\Command\GetUserProfileCommand;
use App\UseCase\Command\RegisterUserCommand;
use App\UseCase\Command\UnfollowUserCommand;
use App\UseCase\Command\UpdateUserCommand;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    use HasTokenViewControllerTrait;

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

        return $this->provideUserTokenView($user);
    }

    /**
     * @Get("/user")
     */
    public function getCurrentUserAction()
    {
        return $this->provideUserTokenView($this->getUser());
    }

    /**
     * @Put("/user")
     */
    public function updateUserAction(Request $request)
    {
        $userData = json_decode($request->getContent(), true)['user'];

        $this->get('use_case.update_user')->execute(
            new UpdateUserCommand(
                $this->getUser(),
                $userData['email'] ?? '',
                $userData['username'] ?? '',
                $userData['password'] ?? '',
                $userData['image'] ?? '',
                $userData['bio'] ?? ''
            )
        );

        return $this->provideUserTokenView($this->getUser());
    }

    /**
     * @Post("/profiles/{username}/follow")
     */
    public function followUserAction(string $username)
    {
        $userToFollow = $this->getDoctrine()->getRepository(User::class)->findOneBy(compact('username'));
        $this->get('use_case.user_follow_user')->execute(new FollowUserCommand($this->getUser(), $userToFollow));

        return $this->profileAction($username);
    }

    /**
     * @Delete("/profiles/{username}/follow")
     */
    public function unfollowUserAction(string $username)
    {
        $userToUnfollow = $this->getDoctrine()->getRepository(User::class)->findOneBy(compact('username'));
        $this->get('use_case.user_unfollow_user')->execute(new UnfollowUserCommand($this->getUser(), $userToUnfollow));

        return $this->profileAction($username);
    }

    /**
     * @Get("/profiles/{username}")
     */
    public function profileAction(string $username)
    {
        return [
            'profile' => $this->get('use_case.get_user_profile')->execute(
                new GetUserProfileCommand($username, $this->getUser())
            ),
        ];
    }
}
