<?php

namespace Snt\Capi\Repository;

use Snt\Capi\Http\HttpRequestParameters;

interface FindParametersInterface
{
    /**
     * @return HttpRequestParameters
     */
    public function buildHttpRequestParameters();
}
