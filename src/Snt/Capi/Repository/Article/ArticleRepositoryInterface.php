<?php
namespace Snt\Capi\Repository\Article;

use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;

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
     * @param FindParameters $findParameters
     *
     * @return array
     * @throws CouldNotFetchResourceRepositoryException
     */
    public function findByIds(FindParameters $findParameters);

    /**
     * @param FindParameters $findParameters
     *
     * @return array
     * @throws CouldNotFetchResourceRepositoryException
     */
    public function findByChangelog(FindParameters $findParameters);
}
