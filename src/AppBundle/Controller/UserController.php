<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\UseCase\Command\GetUserProfileCommand;
use AppBundle\UseCase\FollowUser;
use AppBundle\UseCase\GetUserProfileUseCase;
use AppBundle\UseCase\RegisterUser;
use AppBundle\UseCase\RegisterUserCommand;
use AppBundle\UseCase\FollowUserCommand;
use AppBundle\UseCase\UnfollowUser;
use AppBundle\UseCase\UnfollowUserCommand;
use Core\Repository\UserRepositoryInterface;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

        $user = $this->get(RegisterUser::class)->execute(
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
     * @Get("/profiles/{username}")
     */
    public function profileAction(string $username)
    {
        return [
            'profile' => $this->get(GetUserProfileUseCase::class)->execute(
                new GetUserProfileCommand($username, $this->getUser())
            )
        ];
    }

    /**
     * @Post("/profiles/{username}/follow")
     */
    public function followUserAction(string $username)
    {
        $userToFollow = $this->get(UserRepositoryInterface::class)->findOneBy(compact('username'));
        $this->get(FollowUser::class)->execute(new FollowUserCommand($this->getUser(), $userToFollow));

        return [
            'profile' => $this->get(GetUserProfileUseCase::class)->execute(
                new GetUserProfileCommand($username, $this->getUser())
            )
        ];
    }

    /**
     * @Delete("/profiles/{username}/follow")UserRe
     */
    public function unfollowUserAction(string $username)
    {
        $userToUnfollow = $this->get(UserRepositoryInterface::class)->findOneBy(compact('username'));
        $this->get(UnfollowUser::class)->execute(new UnfollowUserCommand($this->getUser(), $userToUnfollow));

        return [
            'profile' => $this->get(GetUserProfileUseCase::class)->execute(
                new GetUserProfileCommand($username, $this->getUser())
            )
        ];
    }
}
