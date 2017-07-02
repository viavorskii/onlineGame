<?php

namespace RPGBundle\Event;

use RPGBundle\Entity\Interfaces\FightInterface;
use RPGBundle\Entity\User;

/**
 * @author Vladislav Iavorskii
 */
class FightEvent extends AbstractFightEvent
{
    public function run(User $user)
    {
        $fight = $this->fightService->run($user);
        $this->setContent($fight);

        return $this;
    }

    public function process(User $user, FightInterface $fight, $action) : AbstractFightEvent
    {
        $patch = $this->fightService->process($user, $fight, $action);
        $this->setPatch($patch);
        $this->apply($user, $fight);

        return $this;
        
    }


}