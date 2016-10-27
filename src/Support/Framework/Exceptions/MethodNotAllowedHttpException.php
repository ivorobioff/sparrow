<?php
namespace ImmediateSolutions\Support\Framework\Exceptions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class MethodNotAllowedHttpException extends AbstractHttpException
{
    public function __construct()
    {
        parent::__construct('Method Not Allowed', 405);
    }
}