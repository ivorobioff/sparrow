<?php
namespace ImmediateSolutions\Core\Thing\Validation;
use ImmediateSolutions\Core\Thing\Entities\Category;
use ImmediateSolutions\Core\Thing\Validation\Rules\OwnCategory;
use ImmediateSolutions\Core\User\Entities\User;
use ImmediateSolutions\Core\User\Services\UserService;
use ImmediateSolutions\Support\Validation\AbstractThrowableValidator;
use ImmediateSolutions\Support\Validation\Binder;
use ImmediateSolutions\Support\Validation\Property;
use ImmediateSolutions\Support\Validation\Rules\Blank;
use ImmediateSolutions\Support\Validation\Rules\Callback;
use ImmediateSolutions\Support\Validation\Rules\Length;
use ImmediateSolutions\Support\Validation\Rules\Obligate;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CategoryValidator extends AbstractThrowableValidator
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var User
     */
    private $owner;

    /**
     * @var Category
     */
    private $currentCategory;

    /**
     * @param UserService $userService
     * @param User|Category $ownerOrCategory
     */
    public function __construct(UserService $userService, $ownerOrCategory)
    {
        $this->userService = $userService;

        if ($ownerOrCategory instanceof Category){
            $this->owner = $ownerOrCategory->getUser();
            $this->currentCategory = $ownerOrCategory;
        } else {
            $this->owner = $ownerOrCategory;
        }
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('title', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Blank())
                ->addRule(new Length(1, 255));
        });

        $binder->bind('parent', function(Property $property){
            $property
                ->addRule(new OwnCategory($this->userService, $this->owner));

            if ($this->currentCategory){

                $parent = new Callback(function($value){
                    return $value !== $this->currentCategory->getId();
                });

                $parent
                    ->setIdentifier('invalid')
                    ->setMessage('Parent cannot be assigned to itself');

                $property->addRule($parent);
            }
        });
    }
}