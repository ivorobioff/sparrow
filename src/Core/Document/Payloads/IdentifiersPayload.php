<?php
namespace ImmediateSolutions\Core\Document\Payloads;

use IteratorAggregate;
use ArrayIterator;
use Countable;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class IdentifiersPayload implements IteratorAggregate, Countable
{
    /**
     * @var IdentifierPayload[]
     */
    private $identifiers = [];

    /**
     * @param IdentifierPayload $identifier
     */
    public function add(IdentifierPayload $identifier)
    {
        $this->identifiers[] = $identifier;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->identifiers);
    }

    /**
     * @return array
     */
    public function getIds()
    {
        return array_map(function (IdentifierPayload $identifier) {
            return $identifier->getId();
        }, $this->identifiers);
    }

    /**
     * @return array
     */
    public function getTokens()
    {
        return array_map(function (IdentifierPayload $identifier) {
            return $identifier->getToken();
        }, $this->identifiers);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->identifiers);
    }
}