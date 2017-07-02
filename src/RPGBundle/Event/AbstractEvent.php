<?php

namespace RPGBundle\Event;

use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\Event;
use RPGBundle\Entity\Fight;
use RPGBundle\Entity\User;
use RPGBundle\Event\Interfaces\EventInterface;
use RPGBundle\Model\Patch;

/**
 * @author Vladislav Iavorskii
 */
abstract class AbstractEvent implements EventInterface
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var Patch
     */
    protected $patch;

    /**
     * @var mixed
     */
    protected $content;
    
    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct($name, EntityManager $entityManager)
    {
        $this->name = $name;
        $this->entityManager = $entityManager;
    }

    abstract public function run(User $user);

    public function apply(User $user, Fight $fight = null)
    {
        $this->entityManager->getConnection()->beginTransaction();
        try {
            $event = new Event();
            $event->setLife($this->patch->life)
                ->setHitMax($this->patch->hitMax)
                ->setHitMin($this->patch->hitMin)
                ->setEventType($this->name)
                ->setUser($user)
                ->setFight($fight)
            ;

            $user->setHitMax($user->getHitMax() + $this->patch->hitMax);
            $user->setHitMin($user->getHitMin() + $this->patch->hitMin);
            $user->setLife($user->getLife() + $this->patch->life);

            $this->entityManager->persist($event);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }


        return $user;
    }



    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return AbstractEvent
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return AbstractEvent
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return Patch
     */
    public function getPatch()
    {
        if (is_null($this->patch)) {
            $this->patch = new Patch();
        }
        return $this->patch;
    }

    /**
     * @param Patch $patch
     * @return AbstractEvent
     */
    public function setPatch(Patch $patch)
    {
        $this->patch = $patch;
        return $this;
    }

}