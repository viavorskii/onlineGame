<?php

namespace RPGBundle\Event;

use Doctrine\ORM\EntityManager;
use RPGBundle\Event\Interfaces\EventFightInterface;
use RPGBundle\Service\Fight\FightServiceInterface;

/**
 * @author Vladislav Iavorskii
 */
abstract class AbstractFightEvent extends AbstractEvent implements EventFightInterface
{
    /**
     * @var FightServiceInterface
     */
    protected $fightService;

    public function __construct($name, EntityManager $entityManager, FightServiceInterface $fightService)
    {
        parent::__construct($name, $entityManager);
        $this->fightService = $fightService;
    }
}