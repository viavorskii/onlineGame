<?php

namespace RPGBundle\Service;

/**
 * @author Vladislav Iavorskii
 */
class EventGenerator
{
    /**
     * @var array
     */
    private $eventProbabilities;

    public function __construct(array $eventProbabilities)
    {
        $this->eventProbabilities = $eventProbabilities;
    }

    public function generateRandomEvent() : string
    {
        $eventProbability = [];
        foreach ($this->eventProbabilities as $event => $probability) {
            $eventProbability = array_merge(array_fill(0, $probability, $event), $eventProbability);
        }
        return count($eventProbability) ? $eventProbability[rand(0, count($eventProbability) -1)] : "default";
    }
}