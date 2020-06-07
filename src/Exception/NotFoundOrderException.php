<?php

namespace App\Exception;


/**
 * Class NotFoundOrderException
 * @package App\Exception
 */
class NotFoundOrderException extends \Exception
{
    /**
     * @var int
     */
    protected $code = 404;
}