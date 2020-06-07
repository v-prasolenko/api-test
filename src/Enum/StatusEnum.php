<?php

namespace App\Enum;

use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class StatusEnum
 * @package App\Enum
 */
class StatusEnum
{
    /**
     * @var int
     */
    const NEW = 1;
    /**
     * @var int
     */
    const PAY = 2;

    /**
     * @param int $statusId
     * @return string
     */
    public static function getLabel(int $statusId): string
    {
        $labels = self::labels();
        try {
            return $labels[$statusId];
        } catch (Exception $e) {
            throw new NotFoundHttpException('Order status not found');
        }
    }

    /**
     * @return string[]
     */
    protected static function labels()
    {
        return [
            self::NEW => 'Новый',
            self::PAY => 'Оплаченный',
        ];
    }
}

