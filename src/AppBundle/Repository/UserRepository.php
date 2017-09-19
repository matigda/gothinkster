<?php

declare(strict_types = 1);

namespace AppBundle\Repository;

use Core\Entity\User;
use Core\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function add(User $user)
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }
}