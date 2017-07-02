<?php

namespace RPGBundle\Model;

/**
 * @author Vladislav Iavorskii
 */
class Error
{
    public $message = "Something went wrong";

    public function __construct($message = null)
    {
        if ($message) {
            $this->message = $message;
        }
    }
}