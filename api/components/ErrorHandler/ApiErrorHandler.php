<?php

namespace api\components\ErrorHandler;

use yii\web\ErrorHandler;
use yii\web\HttpException;

class ApiErrorHandler extends ErrorHandler
{
    public function handleException($exception)
    {
        parent::handleException(
            new HttpException($exception->getCode(), $exception->getMessage(), $exception->getCode()));
    }
}