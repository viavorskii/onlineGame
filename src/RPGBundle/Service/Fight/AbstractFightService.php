<?php

namespace RPGBundle\Service\Fight;
use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\Fight;
use RPGBundle\Entity\Interfaces\FightInterface;
use RPGBundle\Entity\User;

/**
 * @author Vladislav Iavorskii
 */
abstract class AbstractFightService implements FightServiceInterface
{
    protected $name;

    const STATUS_FIGHT_WAIT = 1;
    const STATUS_FIGHT_LEAVE = 2;
    const STATUS_FIGHT_LOSE = 3;
    const STATUS_FIGHT_WIN = 4;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct($name, EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function run(User $user) : FightInterface
    {
        $fight = new Fight();
        $fight->setMonster($this->getEnemy())
            ->setStatus(AbstractFightService::STATUS_FIGHT_WAIT)
            ->setUser($user)
            ->setType($this->name)
        ;

        $this->content = $fight;

        $this->entityManager->persist($fight);
        $this->entityManager->flush($fight);

        return $fight;
    }

    abstract public function getEnemy();
}