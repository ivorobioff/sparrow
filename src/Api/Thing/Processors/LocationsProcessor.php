<?php
namespace ImmediateSolutions\Api\Thing\Processors;
use ImmediateSolutions\Api\Support\Processor;
use ImmediateSolutions\Core\Thing\Payloads\LocationPayload;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LocationsProcessor extends Processor
{
    public function schema()
    {
        return [
            'name' => 'string',
            'description' => 'string'
        ];
    }

    /**
     * @return LocationPayload
     */
    public function createPayload()
    {
        $payload = new LocationPayload();

        $this->set($payload, 'name');
        $this->set($payload, 'description');

        return $payload;
    }
}