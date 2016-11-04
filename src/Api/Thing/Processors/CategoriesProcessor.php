<?php
namespace ImmediateSolutions\Api\Thing\Processors;
use ImmediateSolutions\Api\Support\Processor;
use ImmediateSolutions\Core\Thing\Payloads\CategoryPayload;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CategoriesProcessor extends Processor
{
    /**
     * @return array
     */
    protected function schema()
    {
        return [
            'title' => 'string',
            'parent' => 'int'
        ];
    }

    /**
     * @return CategoryPayload
     */
    public function createPayload()
    {
        $payload = new CategoryPayload();

        $this->set($payload, 'title');
        $this->set($payload, 'parent');

        return $payload;
    }
}