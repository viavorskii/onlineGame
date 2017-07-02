<?php

namespace RPGBundle\Entity\Interfaces;


interface FightInterface
{
    public function getUser() : CharacterInterface;
    public function setUser($user);
    public function getMonster() : CharacterInterface;
    public function setMonster($monster);
    public function getStatus();
    public function setStatus($status);
    public function getType();
    public function setType($type);

}