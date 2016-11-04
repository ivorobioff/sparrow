<?php
namespace ImmediateSolutions\Core\Thing\Validation;
use ImmediateSolutions\Support\Validation\AbstractThrowableValidator;
use ImmediateSolutions\Support\Validation\Binder;
use ImmediateSolutions\Support\Validation\Property;
use ImmediateSolutions\Support\Validation\Rules\Blank;
use ImmediateSolutions\Support\Validation\Rules\Length;
use ImmediateSolutions\Support\Validation\Rules\Obligate;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LocationValidator extends AbstractThrowableValidator
{
    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('name', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Blank())
                ->addRule(new Length(1, 255));
        });

        $binder->bind('name', function(Property $property){
            $property->addRule(new Length(1, 1000));
        });
    }
}