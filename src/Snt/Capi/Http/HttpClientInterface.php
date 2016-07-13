<?php
namespace Snt\Capi\Http;

use Snt\Capi\Http\Exception\HttpException;

interface HttpClientInterface
{
    const GET_REQUEST = 'GET';

    const NOT_FOUND_STATUS_CODE = 404;

    /**
     * @param string $path
     *
     * @return string
     * @throws HttpException
     */
    public function get($path);
}
