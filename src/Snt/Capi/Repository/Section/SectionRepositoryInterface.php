<?php

namespace Snt\Capi\Repository\Section;

use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;
use Snt\Capi\Repository\FindParametersInterface;

interface SectionRepositoryInterface
{
    /**
     * @param FindAllParameters $findParameters
     *
     * @return array
     * @throws CouldNotFetchResourceRepositoryException
     */
    public function findAll(FindAllParameters $findParameters);
}
