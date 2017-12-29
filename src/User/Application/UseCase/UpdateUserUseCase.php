<?php

declare(strict_types=1);

namespace User\Application\UseCase;

use User\Application\UseCase\Command\UpdateUserCommand;
use User\Application\Entity\User;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use User\Domain\UserRepositoryInterface;

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
