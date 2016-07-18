<?php
namespace Snt\Capi\Repository\Article;

use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;
use Snt\Capi\Repository\FindParametersInterface;

interface ArticleRepositoryInterface
{
    /**
     * @param FindParametersInterface $findParameters
     *
     * @return array|null
     * @throws CouldNotFetchResourceRepositoryException
     */
    public function find(FindParametersInterface $findParameters);

    /**
     * @param FindParametersInterface $findParameters
     *
     * @return array
     * @throws CouldNotFetchResourceRepositoryException
     */
    public function findByIds(FindParametersInterface $findParameters);

    /**
     * @param FindParametersInterface $findParameters
     *
     * @return array
     * @throws CouldNotFetchResourceRepositoryException
     */
    public function findByChangelog(FindParametersInterface $findParameters);
}
