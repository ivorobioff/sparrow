<?php
namespace ImmediateSolutions\Support\Framework\Exceptions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class NotFoundHttpException extends AbstractHttpException
{
    public function __construct()
    {
        parent::__construct('Not Found', 404);
    }
}