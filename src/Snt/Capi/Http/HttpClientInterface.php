<?php
namespace Snt\Capi\Http;

interface HttpClientInterface
{
    /**
     * @param string $path
     *
     * @return string
     */
    public function get($path);
}
