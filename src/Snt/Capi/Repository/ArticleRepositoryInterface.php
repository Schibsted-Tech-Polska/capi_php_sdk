<?php
namespace Snt\Capi\Repository;

use Snt\Capi\Repository\Exception\CouldNotFetchArticleRepositoryException;

interface ArticleRepositoryInterface
{
    /**
     * @param string $articleId
     *
     * @return array
     * @throws CouldNotFetchArticleRepositoryException
     */
    public function find($articleId);

    /**
     * @param array $articleIds
     *
     * @return array
     * @throws CouldNotFetchArticleRepositoryException
     */
    public function findByIds(array $articleIds);
}
