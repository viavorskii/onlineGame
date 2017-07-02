<?php

namespace RPGBundle\Service\Fight;

use RPGBundle\Entity\Interfaces\FightInterface;
use RPGBundle\Entity\User;
use RPGBundle\Model\Patch;

/**
 * @author Vladislav Iavorskii
 */
interface FightServiceInterface
{
    public function run(User $user) : FightInterface;
    public function process(User $user, FightInterface $fight, $action) : Patch;

}