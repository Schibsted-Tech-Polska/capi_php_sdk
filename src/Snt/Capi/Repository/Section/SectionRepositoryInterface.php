<?php

namespace Snt\Capi\Repository\Section;

use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;
use Snt\Capi\Repository\FindParametersInterface;
use Snt\Capi\Repository\Response;

interface SectionRepositoryInterface
{
    /**
     * @param FindAllParameters $findParameters
     *
     * @return Response
     * @throws CouldNotFetchResourceRepositoryException
     */
    public function findAll(FindAllParameters $findParameters);
}
