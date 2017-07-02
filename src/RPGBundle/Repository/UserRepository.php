<?php

namespace RPGBundle\Repository;

use Doctrine\ORM\EntityRepository;
use RPGBundle\Entity\Role;
use RPGBundle\Entity\User;

/**
 * @author Vladislav Iavorskii
 */
class UserRepository extends EntityRepository
{
    public function create($name, Role $role, $password, $secretKey) : User
    {
        $user = new User();
        $user->setName($name)
            ->setRole($role)
            ->setHitMax($role->getHitMax())
            ->setHitMin($role->getHitMin())
            ->setLife($role->getLife())
            ->setPassword($password)
            ->setSecretKey($secretKey)
        ;

        $this->_em->persist($user);
        $this->_em->flush();
        return $user;
    }
}