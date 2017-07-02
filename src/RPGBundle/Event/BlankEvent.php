<?php

namespace RPGBundle\Event;
use RPGBundle\Entity\User;

/**
 * @author Vladislav Iavorskii
 */
class BlankEvent extends AbstractEvent
{
    public function run(User $user)
    {
        return $this;
    }

}