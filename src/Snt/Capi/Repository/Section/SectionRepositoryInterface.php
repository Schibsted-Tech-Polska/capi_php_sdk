<?php

namespace Snt\Capi\Repository\Section;

use Snt\Capi\Repository\Section\Exception\CouldNotFetchSectionRepositoryException;

interface SectionRepositoryInterface
{
    /**
     * @param FindParameters $findParameters
     *
     * @return array
     * @throws CouldNotFetchSectionRepositoryException
     */
    public function findAll(FindParameters $findParameters);
}
