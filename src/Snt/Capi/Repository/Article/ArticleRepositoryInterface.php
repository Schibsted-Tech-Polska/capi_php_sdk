<?php
namespace Snt\Capi\Repository\Article;

use Snt\Capi\Repository\Article\Exception\CouldNotFetchArticleRepositoryException;

interface ArticleRepositoryInterface
{
    /**
     * @param FindParameters $findParameters
     *
     * @return array|null
     * @throws CouldNotFetchArticleRepositoryException
     */
    public function find(FindParameters $findParameters);

    /**
     * @param FindParameters $findParameters
     *
     * @return array
     * @throws CouldNotFetchArticleRepositoryException
     */
    public function findByIds(FindParameters $findParameters);
}
