<?php

declare(strict_types = 1);

namespace Infrastructure\Doctrine\Repository;

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
    public function save()
    {
        $this->_em->flush();
    }

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
}
