<?php

declare(strict_types=1);

namespace App\UseCase;

use App\UseCase\Command\UpdateUserCommand;
use Core\Entity\User;
use Core\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

final class UpdateUserUseCase
{
    /**
     * @var PasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(PasswordEncoderInterface $passwordEncoder, UserRepositoryInterface $userRepository)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
    }

    public function execute(UpdateUserCommand $command): User
    {
        $userToUpdate = $command->getUserToUpdate();

        $userToUpdate->update(
            $command->getNewEmail(),
            $command->getNewUsername(),
            $command->getNewPassword() ? $this->passwordEncoder->encodePassword($command->getNewPassword(), '') : '',
            $command->getNewImage(),
            $command->getNewBio()
        );

        $this->userRepository->save();

        return $userToUpdate;
    }
}
