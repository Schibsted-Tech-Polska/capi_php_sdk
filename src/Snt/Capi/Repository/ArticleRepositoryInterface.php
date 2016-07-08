<?php
namespace Snt\Capi\Repository;

use Snt\Capi\Entity\Article;

interface ArticleRepositoryInterface
{
    /**
     * @param string $articleId
     *
     * @return Article
     */
    public function find($articleId);
}
