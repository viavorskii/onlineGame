<?php

namespace RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity()
 */
class Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="RPGBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="life", type="integer", nullable=true)
     */
    private $life;

    /**
     * @var integer
     *
     * @ORM\Column(name="hitMin", type="integer", nullable=true)
     */
    private $hitMin;

    /**
     * @var integer
     *
     * @ORM\Column(name="hitMax", type="integer", nullable=true)
     */
    private $hitMax;

    /**
     * @var string
     *
     * @ORM\Column(name="eventType", type="string")
     */
    private $eventType;

    /**
     * @var Fight
     *
     * @ORM\ManyToOne(targetEntity="RPGBundle\Entity\Fight")
     * @ORM\JoinColumn(name="fight_id", referencedColumnName="id", nullable=true)
     */
    private $fight;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Event
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Event
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return int
     */
    public function getLife()
    {
        return $this->life;
    }

    /**
     * @param int $life
     * @return Event
     */
    public function setLife($life)
    {
        $this->life = $life;
        return $this;
    }

    /**
     * @return int
     */
    public function getHitMin()
    {
        return $this->hitMin;
    }

    /**
     * @param int $hitMin
     * @return Event
     */
    public function setHitMin($hitMin)
    {
        $this->hitMin = $hitMin;
        return $this;
    }

    /**
     * @return int
     */
    public function getHitMax()
    {
        return $this->hitMax;
    }

    /**
     * @param int $hitMax
     * @return Event
     */
    public function setHitMax($hitMax)
    {
        $this->hitMax = $hitMax;
        return $this;
    }

    /**
     * @return string
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * @param string $eventType
     * @return Event
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
        return $this;
    }

    /**
     * @return Fight
     */
    public function getFight()
    {
        return $this->fight;
    }

    /**
     * @param Fight $fight
     * @return Event
     */
    public function setFight($fight)
    {
        $this->fight = $fight;
        return $this;
    }
}