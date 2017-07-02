<?php

namespace RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use RPGBundle\Entity\Interfaces\CharacterInterface;
use RPGBundle\Entity\Interfaces\FightInterface;

/**
 * Fight
 *
 * @ORM\Table(name="fight")
 * @ORM\Entity(repositoryClass="RPGBundle\Repository\FightRepository")
 */
class Fight implements FightInterface
{
    const STATUS_LOSE = 0;
    const STATUS_WIN = 1;
    const STATUS_LEAVE = 2;

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
     * @var Monster
     *
     * @ORM\ManyToOne(targetEntity="RPGBundle\Entity\Monster")
     * @ORM\JoinColumn(name="monster_id", referencedColumnName="id")
     */
    private $monster;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Fight
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return CharacterInterface
     */
    public function getUser() : CharacterInterface
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Fight
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return CharacterInterface
     */
    public function getMonster() : CharacterInterface
    {
        return $this->monster;
    }

    /**
     * @param Monster $monster
     * @return Fight
     */
    public function setMonster($monster)
    {
        $this->monster = $monster;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return Fight
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Fight
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }


}