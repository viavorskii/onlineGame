<?php

namespace RPGBundle\Event\Interfaces;

use RPGBundle\Entity\Interfaces\FightInterface;
use RPGBundle\Entity\User;

interface EventFightInterface
{
    public function process(User $user, FightInterface $fight, $action);
}