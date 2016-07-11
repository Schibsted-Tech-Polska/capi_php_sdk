<?php
namespace Snt\Capi\Repository;

use Snt\Capi\Entity\Article;

interface ArticleRepositoryInterface
{
    /**
     * @param string $publicationId
     * @param string $articleId
     *
     * @return Article
     */
    public function find($publicationId, $articleId);
}
