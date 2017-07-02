<?php

namespace RPGBundle\Model;

/**
 * @author Vladislav Iavorskii
 */
class Response
{
    public $success = true;
    public $content;
    public $error;
    public $code;

    public function __construct($content, $success = true, $error = null, $code = 200)
    {
        $this->content = $content;
        $this->success = $success;
        $this->error = $error;
        $this->code = $code;
    }
}