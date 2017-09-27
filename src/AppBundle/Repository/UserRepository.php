<?php

declare(strict_types = 1);

namespace AppBundle\Repository;

use AppBundle\ReadModel\Query\UserProfileQuery;
use AppBundle\ReadModel\View\UserProfileView;
use Core\Entity\User;
use Core\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserRepositoryInterface, UserProfileQuery
{
    /**
     * {@inheritdoc}
     */
    public function add(User $user)
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function update(User $user)
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findByUsernameWithFollowingForGivenUser(string $username, User $user): UserProfileView
    {
        $statement = $this->_em->getConnection()->prepare('SELECT * FROM user WHERE username = ?');

        $statement->bindValue(1, $username);
        $statement->execute();

        $results = $statement->fetchAll();

        if (empty($results)) {
            throw new \Exception();
        }

        return new UserProfileView();
    }
}
