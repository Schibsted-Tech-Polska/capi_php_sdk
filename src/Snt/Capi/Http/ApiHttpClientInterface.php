<?php
namespace Snt\Capi\Http;

use Snt\Capi\Http\Exception\ApiHttpClientException;

interface ApiHttpClientInterface
{
    const GET_REQUEST = 'GET';

    const NOT_FOUND_STATUS_CODE = 404;

    /**
     * @param ApiHttpPathAndQuery $apiHttpPathAndQuery
     *
     * @return string
     * @throws ApiHttpClientException
     */
    public function get(ApiHttpPathAndQuery $apiHttpPathAndQuery);
}
