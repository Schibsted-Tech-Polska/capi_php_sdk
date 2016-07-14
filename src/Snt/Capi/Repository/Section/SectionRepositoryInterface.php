<?php

namespace Snt\Capi\Repository\Section;

use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;

interface SectionRepositoryInterface
{
    /**
     * @param FindParameters $findParameters
     *
     * @return array
     * @throws CouldNotFetchResourceRepositoryException
     */
    public function findAll(FindParameters $findParameters);
}
