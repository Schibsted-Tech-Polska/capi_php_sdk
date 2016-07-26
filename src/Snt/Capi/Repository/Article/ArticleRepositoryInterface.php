<?php
namespace Snt\Capi\Repository\Article;

use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;
use Snt\Capi\Repository\FindParametersInterface;

interface ArticleRepositoryInterface
{
    /**
     * @param FindParameters $findParameters
     *
     * @return array|null
     * @throws CouldNotFetchResourceRepositoryException
     */
    public function find(FindParameters $findParameters);

    /**
     * @param FindByIdsParameters $findParameters
     *
     * @return array
     */
    public function findByIds(FindByIdsParameters $findParameters);

    /**
     * @param FindByChangelogParameters $findParameters
     *
     * @return array
     * @throws CouldNotFetchResourceRepositoryException
     */
    public function findByChangelog(FindByChangelogParameters $findParameters);

    /**
     * @param FindBySectionParameters $findParameters
     *
     * @return array
     * @throws CouldNotFetchResourceRepositoryException
     */
    public function findBySections(FindBySectionParameters $findParameters);
}
