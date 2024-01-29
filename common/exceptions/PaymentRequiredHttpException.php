<?php

namespace common\exceptions;

use Exception;
use yii\web\HttpException;

/**
 * 抛出请先付款的异常，状态码为402
 */
class PaymentRequiredHttpException extends HttpException
{
    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        parent::__construct(402, $message, $code, $previous);
    }
}