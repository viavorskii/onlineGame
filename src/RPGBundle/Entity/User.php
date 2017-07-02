<?php

namespace RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use RPGBundle\Entity\Interfaces\CharacterInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="RPGBundle\Repository\UserRepository")
 */
class User implements CharacterInterface
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
     * @var Role
     *
     * @ORM\ManyToOne(targetEntity="RPGBundle\Entity\Role")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private $role;

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
     * @var string
     *
     * @ORM\Column(name="password", type="string")
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="secret_key", type="string")
     */
    private $secretKey;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
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
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return integer
     */
    public function getHitMin()
    {
        return $this->hitMin;
    }

    /**
     * @param integer $hitMin
     * @return User
     */
    public function setHitMin($hitMin)
    {
        $this->hitMin = $hitMin;
        return $this;
    }

    /**
     * @return integer
     */
    public function getHitMax()
    {
        return $this->hitMax;
    }

    /**
     * @param integer $hitMax
     * @return User
     */
    public function setHitMax($hitMax)
    {
        $this->hitMax = $hitMax;
        return $this;
    }

    /**
     * @return integer
     */
    public function getLife()
    {
        return $this->life;
    }

    /**
     * @param integer $life
     * @return User
     */
    public function setLife($life)
    {
        $this->life = $life;
        return $this;
    }

    /**
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param Role $role
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param string $secretKey
     * @return User
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
        return $this;
    }
}
