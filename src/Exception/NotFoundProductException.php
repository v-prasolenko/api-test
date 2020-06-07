<?php

namespace App\Exception;


/**
 * Class NotFoundProductException
 * @package App\Exception
 */
class NotFoundProductException extends \Exception
{
    /**
     * @var int
     */
    protected $code = 404;
}