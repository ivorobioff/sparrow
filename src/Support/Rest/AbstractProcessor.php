<?php
namespace ImmediateSolutions\Support\Rest;
use ImmediateSolutions\Support\Core\Options\PropertiesToClearInterface;
use ImmediateSolutions\Support\Framework\ContainerInterface;
use ImmediateSolutions\Support\Rest\Validation\Rules\DocumentMixedIdentifier;
use ImmediateSolutions\Support\Validation\Binder;
use ImmediateSolutions\Support\Validation\ErrorsThrowableCollection;
use ImmediateSolutions\Support\Validation\Performer;
use ImmediateSolutions\Support\Validation\Property;
use ImmediateSolutions\Support\Validation\RuleInterface;
use ImmediateSolutions\Support\Validation\Rules\BooleanCast;
use ImmediateSolutions\Support\Validation\Rules\Callback;
use ImmediateSolutions\Support\Validation\Rules\Each;
use ImmediateSolutions\Support\Validation\Rules\FloatCast;
use ImmediateSolutions\Support\Validation\Rules\IntegerCast;
use ImmediateSolutions\Support\Validation\Rules\Moment;
use ImmediateSolutions\Support\Validation\Rules\StringCast;
use ImmediateSolutions\Support\Validation\Rules\Walk;
use ImmediateSolutions\Support\Validation\Source\ArraySourceHandler;
use Psr\Http\Message\RequestInterface;
use RuntimeException;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractProcessor
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    private $data;

    /**
     * @var ErrorsThrowableCollection
     */
    private $errors;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->request = $container->get(RequestInterface::class);
    }

    /**
     * @param string $path
     * @param mixed $default
     * @return mixed
     */
    protected function get($path, $default = null)
    {
        return array_get($this->getData(), $path, $default);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if ($this->data === null){
            $data = $this->request->getBody()->getContents();

            $data = json_decode($data, true);

            if ($data === null){
                $this->data = [];
            } else {
                $this->data = $data;
            }
        }

        return $this->data;
    }

    public function validate()
    {
        $errors = $this->getErrors();

        if (count($errors) > 0){
            throw $errors;
        }
    }

    /**
     * @return array
     */
    protected function schema()
    {
        return [];
    }

    /**
     * @return ErrorsThrowableCollection
     */
    public function getErrors()
    {
        if ($this->errors === null) {

            $binder = new Binder();
            $this->rules($binder);

            $this->errors = (new Performer())->perform($binder, new ArraySourceHandler($this->getData()));
        }

        return $this->errors;
    }

    /**
     * @param Binder $binder
     */
    protected function rules(Binder $binder)
    {
        foreach ($this->schema() as $name => $rule) {

            $binder->bind($name, $this->createRootInflator($rule));
        }
    }

    /**
     * @param string|array $rule
     * @return callable
     */
    private function createRootInflator($rule)
    {
        return function (Property $property) use($rule) {

            if (is_string($rule) && ends_with($rule, '[]')){
                $rule = [cut_string_right($rule, '[]')];
            }

            if (is_array($rule) && count($rule) === 1 && array_key_exists(0, $rule)){
                $property->addRule(new Each(function() use ($rule){
                    return $this->resolveRule(current($rule));
                }));
            } else {
                $property->addRule($this->resolveRule($rule));
            }
        };
    }

    /**
     *
     * @param mixed $rule
     * @return RuleInterface
     */
    private function resolveRule($rule)
    {
        if (is_string($rule)) {
            $rule = $this->mapRules()[$rule];
        }

        if (is_callable($rule)) {
            return call_user_func($rule);
        }

        if (is_object($rule)) {
            return $rule;
        }

        if (is_string($rule)) {
            return new $rule();
        }

        if (is_array($rule)) {
            return new Walk(function (Binder $binder) use($rule) {
                foreach ($rule as $key => $value) {
                    $binder->bind($key, $this->createRootInflator($value));
                }
            });
        }

        throw new RuntimeException('Unable to resolve a validation rule.');
    }

    /**
     *
     * @return array
     */
    protected function mapRules()
    {
        return [
            'string' => StringCast::class,
            'bool' => BooleanCast::class,
            'int' => IntegerCast::class,
            'float' => FloatCast::class,
            'datetime' => Moment::class,
            'document' => DocumentMixedIdentifier::class,
            'array' => (new Callback(function($v){
                return is_array($v);
            }))
                ->setIdentifier('cast')
                ->setMessage('The field should be an array.')
        ];
    }

    /**
     *
     * @param PropertiesToClearInterface $options
     * @return PropertiesToClearInterface
     */
    public function getPropertiesToClear(PropertiesToClearInterface $options = null)
    {
        if ($options === null) {
            $options = new UpdateOptions();
        }

        $data = array_keys(array_filter(
            array_dot($this->getData()),
            function($value){ return $value === null;}
        ));

        $options->setPropertiesToClear($data);

        return $options;
    }
}