<?php

namespace Snt\Capi\Http;

final class ApiHttpPathAndQuery
{
    /**
     * @var string
     */
    private $path = '';

    /**
     * @var string
     */
    private $query = '';

    private function __construct()
    {
    }

    /**
     * @param string $path
     * @param string $query
     *
     * @return ApiHttpPathAndQuery
     */
    public static function createForPathAndQuery($path, $query)
    {
        $self = new self();

        $self->path = $path;
        $self->query = $query;

        return $self;
    }

    /**
     * @param string $path
     *
     * @return ApiHttpPathAndQuery
     */
    public static function createForPath($path)
    {
        $self = new self();

        $self->path = $path;

        return $self;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function getPathAndQuery()
    {
        return sprintf('%s?%s', $this->path, $this->query);
    }
}
