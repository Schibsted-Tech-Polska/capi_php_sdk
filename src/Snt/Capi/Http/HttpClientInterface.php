<?php
namespace Snt\Capi\Http;

use Snt\Capi\Http\Exception\HttpException;

interface HttpClientInterface
{
    const GET_REQUEST = 'GET';

    const NOT_FOUND_STATUS_CODE = 404;

    /**
     * @param HttpRequestParameters $httpRequestParameters
     *
     * @return string
     * @throws HttpException
     */
    public function get(HttpRequestParameters $httpRequestParameters);
}
