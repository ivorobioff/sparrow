<?php
namespace ImmediateSolutions\Api\Thing\Processors;
use ImmediateSolutions\Core\Thing\Payloads\ThingPayload;
use ImmediateSolutions\Support\Rest\AbstractProcessor;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingsProcessor extends AbstractProcessor
{
    protected function schema()
    {
        return [
            'name' => 'string',
            'description' => 'string',
            'category' => 'int',
            'locations' => 'int[]',
            'rate' => 'int'
        ];
    }

    /**
     * @return ThingPayload
     */
    public function createPayload()
    {
        $payload = new ThingPayload();
        $payload->setName($this->get('name'));

        return $payload;
    }
}