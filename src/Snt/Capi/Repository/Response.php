<?php

namespace Snt\Capi\Repository;

use ArrayAccess;
use OutOfBoundsException;

/**
 * @method int getTotal()
 * @method int getCount()
 * @method array getArticles()
 * @method array getTeasers()
 * @method array getSections()
 */
final class Response implements ArrayAccess
{
    const INDEX_IS_NOT_PRESENT_PATTERN = '"%s" index is not present in response';

    private $response;

    /**
     * @param array|null $response
     *
     * @return self
     */
    public static function createFrom($response)
    {
        $self = new self();

        $self->response = $response;

        return $self;
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return array
     * @throws OutOfBoundsException
     */
    public function __call($name, array $arguments)
    {
        $index = mb_strtolower(str_replace('get', '', $name));

        if (isset($this->response[$index])) {
            return $this->response[$index];
        }

        throw new OutOfBoundsException(
            sprintf(self::INDEX_IS_NOT_PRESENT_PATTERN, $index)
        );
    }

    /**
     * @return bool
     */
    public function isNull()
    {
        return is_null($this->response);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return (array) $this->response;
    }

    public function offsetExists($offset)
    {
        return isset($this->response[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->response[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->response[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->response[$offset]);
    }
}
