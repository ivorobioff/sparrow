<?php
namespace ImmediateSolutions\Api\Thing\Processors;
use ImmediateSolutions\Api\Support\Processor;
use ImmediateSolutions\Core\Thing\Enums\Attitude;
use ImmediateSolutions\Core\Thing\Payloads\ThingPayload;
use ImmediateSolutions\Support\Validation\Rules\Enum;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingsProcessor extends Processor
{
    protected function schema()
    {
        return [
            'name' => 'string',
            'description' => 'string',
            'attitude' => new Enum(Attitude::class),
            'category' => 'int',
            'locations' => 'int[]',
            'rate' => 'int',
            'image' => 'document'
        ];
    }

    /**
     * @return ThingPayload
     */
    public function createPayload()
    {
        $payload = new ThingPayload();

        $this->set($payload, 'name');
        $this->set($payload, 'description');
        $this->set($payload, 'attitude', $this->asEnum(Attitude::class), false);
        $this->set($payload, 'category');
        $this->set($payload, 'locations', null, false);
        $this->set($payload, 'rate');
        $this->set($payload, 'image', $this->asDocument());

        return $payload;
    }
}