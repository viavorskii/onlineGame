<?php

namespace RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity()
 */
class Role
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
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="hit_min", type="integer")
     */
    private $hitMin;

    /**
     * @var integer
     *
     * @ORM\Column(name="hit_max", type="integer")
     */
    private $hitMax;

    /**
     * @var integer
     *
     * @ORM\Column(name="life", type="integer")
     */
    private $life;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Role
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return Role
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
     * @return Role
     */
    public function setHitMax($hitMax)
    {
        $this->hitMax = $hitMax;
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
     * @return Role
     */
    public function setLife($life)
    {
        $this->life = $life;
        return $this;
    }
}