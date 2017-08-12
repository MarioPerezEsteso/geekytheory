<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionFactory
{
    /**
     * Application error codes.
     */
    const CODE_MODEL_NOT_FOUND = 1;

    /**
     * Create not found exception.
     *
     * @param $message
     * @param $previous
     *
     * @return NotFoundHttpException
     */
    public static function createModelNotFoundException($message = null, $previous = null)
    {
        $message = empty($message) ? 'Model not found' : $message;
        return new NotFoundHttpException($message, $previous, self::CODE_MODEL_NOT_FOUND);
    }
}