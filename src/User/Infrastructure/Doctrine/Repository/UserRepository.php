<?php

declare(strict_types=1);

namespace User\Infrastructure\Doctrine\Repository;

use User\Application\ReadModel\Query\UserProfileQuery;
use User\Application\ReadModel\View\UserProfileView;
use User\Application\Entity\User as AppUser;
use Doctrine\ORM\EntityRepository;
use User\Domain\User;
use User\Domain\UserRepositoryInterface;

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
    public function save()
    {
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function findByUsernameForGivenUser(string $username, User $user): UserProfileView
    {
        $statement = $this->_em->getConnection()->prepare(
            '
              SELECT * FROM user
              LEFT JOIN users_followers uf
              ON uf.follower_id = ?
              WHERE username = ?
            '
        );

        $statement->bindValue(1, $user->getId());
        $statement->bindValue(2, $username);
        $statement->execute();

        $results = $statement->fetchAll();

        if (empty($results)) {
            throw new \Exception();
        }

        $result = $results[0];

        return new UserProfileView($result['username'], $result['bio'], $result['image'], (bool) $result['follower_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserByUsername(string $username): User
    {
        return $this->findOneBy(compact('username'));
    }

    public function findUserByEmail(string $email): AppUser
    {
        return $this->findOneBy(compact('email'));
    }
}
