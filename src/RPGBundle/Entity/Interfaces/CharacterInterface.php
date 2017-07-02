<?php

namespace RPGBundle\Entity\Interfaces;

/**
 * @author Vladislav Iavorskii
 */
Interface CharacterInterface
{
    public function getHitMin();
    public function setHitMin($hitMin);

    public function getHitMax();
    public function setHitMax($hitMax);

    public function getLife();
    public function setLife($life);
}