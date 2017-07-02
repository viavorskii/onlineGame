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
        $this->entityManager->getConnection()->beginTransaction();
        try {
        
            $patch = $this->fightService->process($user, $fight, $action);
            $this->setPatch($patch);
            $this->apply($user, $fight);

            $this->entityManager->persist($user);
            $this->entityManager->persist($fight);
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }

        return $this;
    }


}