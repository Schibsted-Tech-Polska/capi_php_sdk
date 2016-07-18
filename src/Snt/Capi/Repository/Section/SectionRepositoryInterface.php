<?php

namespace Snt\Capi\Repository\Section;

use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;
use Snt\Capi\Repository\FindParametersInterface;

interface SectionRepositoryInterface
{
    /**
     * @param FindParametersInterface $findParameters
     *
     * @return array
     * @throws CouldNotFetchResourceRepositoryException
     */
    public function findAll(FindParametersInterface $findParameters);
}
