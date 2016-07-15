<?php

namespace Snt\Capi\Http;

final class HttpRequestParameters
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
     * @return HttpRequestParameters
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
     * @return HttpRequestParameters
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
}
