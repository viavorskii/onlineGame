<?php

namespace RPGBundle\Service;

use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\Fight;
use RPGBundle\Event\AbstractEvent;
use RPGBundle\Exception\UserException;
use RPGBundle\Service\Fight\AbstractFightService;

/**
 * @author Vladislav Iavorskii
 */
class ExploreService
{
    /**
     * @var array
     */
    private $eventProbabilities = [];

    /**
     * @var EntityManager
     */
    private $entityManager;
    
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var EventFactory
     */
    private $eventFactory;

    public function __construct(EntityManager $entityManager, UserService $userService, EventFactory $eventFactory, $eventProbabilities)
    {
        $this->entityManager = $entityManager;
        $this->userService = $userService;
        $this->eventFactory = $eventFactory;
        $this->eventProbabilities = $eventProbabilities;
    }

    public function step($userId) : AbstractEvent
    {
        $user = $this->userService->get($userId);
        if (!$user) {
            throw new UserException("User is not found");
        }

        $actualFight = $this->userService->getActualFight($user);
        if ($actualFight) {
            //we are checking the current fight to not to let a user to go further
            $event = $this->eventFactory->create($actualFight->getType());
            $event->setContent($actualFight);
        } else {
            $happened = $this->generateRandomEvent();
            $event = $this->eventFactory->create($happened);
            $event = $event->run($user);
        }

        return $event;
    }

    public function fight($userId, $fightId, $action) : AbstractEvent
    {
        $user = $this->userService->get($userId);
        if (!$user) {
            throw new UserException("This user is not found");
        }
        $fightRepo = $this->entityManager->getRepository(Fight::class);
        $fight = $fightRepo->get($fightId, $user);
        if (!$fight) {
            throw new UserException("Fight is not found");
        }
        $event = $this->eventFactory->createFightEvent($fight->getType());
        if ($fight->getStatus() == AbstractFightService::STATUS_FIGHT_WAIT) {
            $event->process($user, $fight, $action);
        }

        $event->setContent($fight);
        return $event;
    }

    private function generateRandomEvent() : string
    {
        $eventProbability = [];
        foreach ($this->eventProbabilities as $event => $probability) {
            $eventProbability = array_merge(array_fill(0, $probability, $event), $eventProbability);
        }
        return count($eventProbability) ? $eventProbability[rand(0, count($eventProbability) -1)] : "default";
    }
}