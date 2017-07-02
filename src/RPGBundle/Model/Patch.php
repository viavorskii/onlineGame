<?php

namespace RPGBundle\Model;

/**
 * @author Vladislav Iavorskii
 */
class Patch
{
    public $life;
    public $hitMin;
    public $hitMax;

    public function increaseHit(int $value)
    {
        $this->hitMax += $value;
        $this->hitMin += $value;
    }

    public function increaseLife(int $value)
    {
        $this->life += $value;
    }
}