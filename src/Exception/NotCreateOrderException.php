<?php

namespace App\Exception;


/**
 * Class NotCreateOrderException
 * @package App\Exception
 */
class NotCreateOrderException extends \Exception
{
    /**
     * @var int
     */
    protected $code = 500;
}