<?php

namespace Symfony\Bundle\UserBundle\Manager;

use Symfony\Bundle\UserBundle\Entity\User;
use FOS\UserBundle\Doctrine\UserManager as BaseManager;

class UserManager extends BaseManager
{
    public function getUserQuery()
    {
        $qb = $this->repository->createQueryBuilder('u');
        $query = $qb
            ->getQuery();
        return $query;
    }

    public function changeUserPassword(User $user, $newPassword)
    {
        $user->setPlainPassword($newPassword);
        $this->updatePassword($user);

        if (0 !== strlen($newPassword)) {
            $this->objectManager->persist($user);
            $this->objectManager->flush();
        }
    }
}