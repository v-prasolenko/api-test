<?php

namespace App\Exception;


/**
 * Class AlreadyPayedOrderException
 * @package App\Exception
 */
class AlreadyPayedOrderException extends \Exception
{
    /**
     * @var int
     */
    protected $code = 500;
}