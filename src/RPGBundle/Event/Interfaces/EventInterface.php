<?php

namespace RPGBundle\Event\Interfaces;

use RPGBundle\Entity\User;

interface EventInterface
{
    public function run(User $user);
}