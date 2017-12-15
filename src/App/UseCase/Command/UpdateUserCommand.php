<?php

declare(strict_types=1);

namespace App\UseCase\Command;

use Core\Entity\User;

final class UpdateUserCommand
{
    /**
     * @var User
     */
    private $userToUpdate;

    /**
     * @var string
     */
    private $newEmail;

    /**
     * @var string
     */
    private $newUsername;

    /**
     * @var string
     */
    private $newPassword;

    /**
     * @var string
     */
    private $newImage;

    /**
     * @var string
     */
    private $newBio;

    public function __construct(
        User $userToUpdate,
        string $newEmail = '',
        string $newUsername = '',
        string $newPassword = '',
        string $newImage = '',
        string $newBio = ''
    )
    {
        $this->userToUpdate = $userToUpdate;
        $this->newEmail = $newEmail;
        $this->newUsername = $newUsername;
        $this->newPassword = $newPassword;
        $this->newImage = $newImage;
        $this->newBio = $newBio;
    }

    public function getUserToUpdate(): User
    {
        return $this->userToUpdate;
    }

    public function getNewEmail(): string
    {
        return $this->newEmail;
    }

    public function getNewUsername(): string
    {
        return $this->newUsername;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function getNewImage(): string
    {
        return $this->newImage;
    }

    public function getNewBio(): string
    {
        return $this->newBio;
    }
}
