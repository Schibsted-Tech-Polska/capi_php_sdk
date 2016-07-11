<?php
namespace Snt\Capi\Http;

use Snt\Capi\Http\Exception\CouldNotMakeHttpGetRequest;

interface HttpClientInterface
{
    const GET_REQUEST = 'GET';

    /**
     * @param string $path
     *
     * @return string
     * @throws CouldNotMakeHttpGetRequest
     */
    public function get($path);
}
