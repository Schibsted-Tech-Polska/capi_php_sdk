<?php
namespace Snt\Capi\Repository;

use Snt\Capi\Entity\Article;
use Snt\Capi\Repository\Exception\CouldNotFetchArticleException;

interface ArticleRepositoryInterface
{
    /**
     * @param string $articleId
     *
     * @return Article
     * @throws CouldNotFetchArticleException
     */
    public function find($articleId);

    /**
     * @param array $articleIds
     *
     * @return Article[]
     * @throws CouldNotFetchArticleException
     */
    public function findByIds(array $articleIds);
}
