<?php

namespace RPGBundle\Service\Fight;
 
use RPGBundle\Entity\Interfaces\FightInterface;
use RPGBundle\Entity\Monster;
use RPGBundle\Entity\User;
use RPGBundle\Exception\UserException;
use RPGBundle\Model\Patch;


/**
 * @author Vladislav Iavorskii
 */
class HardFightService extends AbstractFightService
{
    const FIGHT_ACTION_FIGHT = 'fight';
    const FIGHT_ACTION_SKIP = 'skip';

    public static $fightActions = [
        self::FIGHT_ACTION_FIGHT,
        self::FIGHT_ACTION_SKIP
    ];

    public function process(User $user, FightInterface $fight, $action) : Patch
    {
        if (!in_array($action, self::$fightActions)) {
            throw new UserException("This fight action is not found");
        }

        $patch = new Patch();
        if ($action == self::FIGHT_ACTION_FIGHT) {
            $monsterHit = $this->getStraightHit($fight->getMonster()->getHitMin(), $fight->getMonster()->getHitMax());
            $userHit = $this->getStraightHit($user->getHitMin(), $user->getHitMax());
            $patch->increaseLife(($userHit - $monsterHit) * 2);
            if ($monsterHit > $userHit) {
                $fight->setStatus(self::STATUS_FIGHT_LOSE);
            } else {
                $fight->setStatus(self::STATUS_FIGHT_WIN);
            }
            $this->entityManager->persist($fight);
            $this->entityManager->flush($fight);
        } else if ($action == self::FIGHT_ACTION_SKIP) {
            $patch->increaseLife(-2);
        }

        return $patch;
    }

    private function getStraightHit($from, $to)
    {
        return rand($from, $to);
    }

    public function getEnemy() : Monster
    {
        $monsterRepo = $this->entityManager->getRepository(Monster::class);
        $monsters = $monsterRepo->findAll();

        return $monsters[array_rand($monsters)];
    }
}