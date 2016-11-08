<?php
namespace Snt\Capi\Repository\Article;

use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;
use Snt\Capi\Repository\Response;

interface ArticleRepositoryInterface
{
    /**
     * @param FindParameters $findParameters
     *
     * @return Response
     * @throws CouldNotFetchResourceRepositoryException
     */
    public function find(FindParameters $findParameters);

    /**
     * @param FindByIdsParameters $findParameters
     *
     * @return Response
     */
    public function findByIds(FindByIdsParameters $findParameters);

    /**
     * @param FindByChangelogParameters $findParameters
     *
     * @return Response
     * @throws CouldNotFetchResourceRepositoryException
     */
    public function findByChangelog(FindByChangelogParameters $findParameters);

    /**
     * @param FindBySectionParameters $findParameters
     *
     * @return Response
     * @throws CouldNotFetchResourceRepositoryException
     */
    public function findBySections(FindBySectionParameters $findParameters);
}
