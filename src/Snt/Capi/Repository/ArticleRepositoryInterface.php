<?php
namespace Snt\Capi\Repository;

use Snt\Capi\Repository\Exception\CouldNotFetchArticleRepositoryException;

interface ArticleRepositoryInterface
{
    /**
     * @param string $publicationId
     * @param string $articleId
     *
     * @return mixed
     * @throws CouldNotFetchArticleRepositoryException
     */
    public function findForPublicationId($publicationId, $articleId);

    /**
     * @param string $publicationId
     * @param array $articleIds
     *
     * @return mixed
     * @throws CouldNotFetchArticleRepositoryException
     */
    public function findByIdsForPublicationId($publicationId, array $articleIds);
}
