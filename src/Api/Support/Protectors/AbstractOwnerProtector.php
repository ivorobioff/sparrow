<?php
namespace ImmediateSolutions\Api\Support\Protectors;
use ImmediateSolutions\Support\Framework\Action;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractOwnerProtector extends AuthProtector
{
    /**
     * @param Action $action
     * @return bool
     */
    public function grants(Action $action)
    {
        if (!parent::grants($action)){
            return false;
        }

        $arguments = $action->getArguments();

        if (!$arguments){
            return false;
        }

        $id = array_first($arguments);

        return $this->isOwner($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    abstract protected function isOwner($id);
}