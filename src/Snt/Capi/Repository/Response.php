<?php

namespace Snt\Capi\Repository;

use ArrayAccess;
use OutOfBoundsException;

final class Response implements ArrayAccess
{
    const SECTIONS_KEY_IS_NOT_PRESENT = 'Sections key is not present';

    const ARTICLES_KEY_IS_NOT_PRESENT = 'Articles key is not present';

    const TEASERS_KEY_IS_NOT_PRESENT = 'Teasers key is not present';

    const COUNT_KEY_IS_NOT_PRESENT = 'Count key is not present';

    private $response;

    /**
     * @param array $response
     *
     * @return self
     */
    public static function createFrom(array $response)
    {
        $self = new self();

        $self->response = $response;

        return $self;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }

    /**
     * @return int|null
     * @throws OutOfBoundsException
     */
    public function getTotal()
    {
        if (isset($this->response['total'])) {
            return (int) $this->response['total'];
        }

        throw new OutOfBoundsException('Total key is not present');
    }

    /**
     * @return int|null
     * @throws OutOfBoundsException
     */
    public function getCount()
    {
        if (isset($this->response['count'])) {
            return (int) $this->response['count'];
        }

        throw new OutOfBoundsException(self::COUNT_KEY_IS_NOT_PRESENT);
    }

    /**
     * @return array
     * @throws OutOfBoundsException
     */
    public function getTeasers()
    {
        if (isset($this->response['teasers'])) {
            return $this->response['teasers'];
        }

        throw new OutOfBoundsException(self::TEASERS_KEY_IS_NOT_PRESENT);
    }

    /**
     * @return array
     * @throws OutOfBoundsException
     */
    public function getSections()
    {
        if (isset($this->response['sections'])) {
            return $this->response['sections'];
        }

        throw new OutOfBoundsException(self::SECTIONS_KEY_IS_NOT_PRESENT);
    }

    /**
     * @return array
     * @throws OutOfBoundsException
     */
    public function getArticles()
    {
        if (isset($this->response['articles'])) {
            return $this->response['articles'];
        }

        throw new OutOfBoundsException(self::ARTICLES_KEY_IS_NOT_PRESENT);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->response[$offset]);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        return $this->response[$offset];
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->response[$offset] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->response[$offset]);
    }
}
