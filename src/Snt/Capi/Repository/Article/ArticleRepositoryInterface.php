<?php
namespace Snt\Capi\Repository\Article;

use Snt\Capi\Repository\Article\Exception\CouldNotFetchArticleRepositoryException;

interface ArticleRepositoryInterface
{
    /**
     * @param FindParameters $findParameters
     *
     * @return mixed
     * @throws CouldNotFetchArticleRepositoryException
     */
    public function find(FindParameters $findParameters);

    /**
     * @param FindByIdsParameters $findByIdsParameters
     *
     * @return mixed
     * @throws CouldNotFetchArticleRepositoryException
     */
    public function findByIds(FindByIdsParameters $findByIdsParameters);
}
