<?php
namespace ImmediateSolutions\Support\Framework\Exceptions;

use RuntimeException;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractHttpException extends RuntimeException
{
    /**
     * @param string $message
     * @param int $code
     */
    public function __construct($message = 'Internal Server Error', $code = 500)
    {
        parent::__construct($message, $code);
    }
}