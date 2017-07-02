<?php

namespace RPGBundle\Service;

use RPGBundle\Event\AbstractEvent;
use RPGBundle\Event\AbstractFightEvent;

/**
 * @author Vladislav Iavorskii
 */
class EventFactory
{
    private $events;

    public function __construct($events)
    {
        $this->events = $events;
    }
    public function create($eventType) : AbstractEvent
    {
        return isset($this->events[$eventType]) ? $this->events[$eventType] : $this->events["default"];
    }

    /**
     * @param $type
     * @return AbstractFightEvent
     * @throws \Exception
     */
    public function createFightEvent($type)
    {
        if ($this->events[$type] instanceof AbstractFightEvent) {
            return $this->events[$type];
        } else {
            throw new \Exception("Requested event is not extending the AbstractFightEvent");
        }
    }
}