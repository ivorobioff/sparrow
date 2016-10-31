<?php
namespace ImmediateSolutions\Support\Framework\Exceptions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ForbiddenHttpException extends AbstractHttpException
{
    public function __construct()
    {
        parent::__construct('Forbidden', 403);
    }
}