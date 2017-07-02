<?php

namespace RPGBundle\Event;

use RPGBundle\Entity\User;
use RPGBundle\Model\Patch;

/**
 * @author Vladislav Iavorskii
 */
class StumbledEvent extends AbstractEvent
{
    const NAME = 'stumbled';

    public function run(User $user)
    {
        $value = (-1) * rand(1,5);

        $patch = new Patch();
        $patch->increaseHit($value);
        $patch->increaseLife($value);

        $this->setPatch($patch);
        $this->apply($user);

        return $this;
    }

}