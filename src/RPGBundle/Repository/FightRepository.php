<?php

namespace RPGBundle\Repository;

use Doctrine\ORM\EntityRepository;
use RPGBundle\Entity\Fight;
use RPGBundle\Entity\User;
use RPGBundle\Exception\UserException;

/**
 * @author Vladislav Iavorskii
 */
class FightRepository extends EntityRepository
{
    /**
     * @param $id
     * @param $user
     * @return Fight
     * @throws UserException
     */
    public function get($id, User $user) : Fight
    {
        $fight = $this->findOneBy(["id" => $id, "user" => $user]);

        return $fight;
    }
}