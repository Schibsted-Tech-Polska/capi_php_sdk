<?php

namespace Snt\Capi\Repository;

use Snt\Capi\Http\ApiHttpPathAndQuery;

interface FindParametersInterface
{
    /**
     * @return ApiHttpPathAndQuery
     */
    public function buildApiHttpPathAndQuery();
}
