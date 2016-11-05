<?php
namespace ImmediateSolutions\Core\Thing\Validation;
use ImmediateSolutions\Core\Document\Validation\Inflators\DocumentInflator;
use ImmediateSolutions\Core\Thing\Entities\Thing;
use ImmediateSolutions\Core\Thing\Validation\Rules\OwnCategory;
use ImmediateSolutions\Core\Thing\Validation\Rules\OwnLocation;
use ImmediateSolutions\Core\User\Entities\User;
use ImmediateSolutions\Core\User\Services\UserService;
use ImmediateSolutions\Support\Framework\ContainerInterface;
use ImmediateSolutions\Support\Validation\AbstractThrowableValidator;
use ImmediateSolutions\Support\Validation\Binder;
use ImmediateSolutions\Support\Validation\Property;
use ImmediateSolutions\Support\Validation\Rules\Blank;
use ImmediateSolutions\Support\Validation\Rules\Greater;
use ImmediateSolutions\Support\Validation\Rules\Length;
use ImmediateSolutions\Support\Validation\Rules\Less;
use ImmediateSolutions\Support\Validation\Rules\Obligate;
use ImmediateSolutions\Support\Validation\Rules\Unique;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingValidator extends AbstractThrowableValidator
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Thing
     */
    private $currentThing;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var User
     */
    private $owner;

    /**
     * @param ContainerInterface $container
     * @param User|Thing $thingOrOwner
     */
    public function __construct(ContainerInterface $container, $thingOrOwner)
    {
        $this->container = $container;
        $this->userService = $container->get(UserService::class);

        if ($thingOrOwner instanceof Thing){
            $this->currentThing = $thingOrOwner;
            $this->owner = $thingOrOwner->getUser();
        } else {
            $this->owner = $thingOrOwner;
        }
    }

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

        $binder->bind('description', function(Property $property){
            $property
                ->addRule(new Length(1, 1000));
        });

        $binder->bind('attitude', function(Property $property){
            $property
                ->addRule(new Obligate());
        });

        $binder->bind('rate', function(Property $property){
            $property
                ->addRule(new Greater(0))
                ->addRule(new Less(5));
        });

        $document = new DocumentInflator($this->container);
        $document->setRequired(false);

        if ($this->currentThing && $this->currentThing->getImage()){
            $document->setTrustedDocuments([$this->currentThing->getImage()]);
        }

        $binder->bind('image', $document);

        $binder->bind('category', function(Property $property){
            $property->addRule(new OwnCategory($this->userService, $this->owner));
        });

        $binder->bind('locations', function(Property $property){
            $property
                ->addRule(new Unique())
                ->addRule(new OwnLocation($this->userService, $this->owner));
        });
    }
}