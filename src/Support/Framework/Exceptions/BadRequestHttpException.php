<?php
namespace ImmediateSolutions\Support\Framework\Exceptions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class BadRequestHttpException extends AbstractHttpException
{
    public function __construct()
    {
        parent::__construct('Bad Request', 400);
    }
}