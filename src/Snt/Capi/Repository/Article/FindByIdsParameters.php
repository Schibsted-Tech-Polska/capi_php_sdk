<?php

namespace Snt\Capi\Repository\Article;

final class FindByIdsParameters
{
    /**
     * @var string
     */
    private $publicationId;

    /**
     * @var int[]
     */
    private $articleIds;

    /**
     * @param string $publicationId
     * @param int[] $articleIds
     */
    private function __construct($publicationId, array $articleIds)
    {
        $this->publicationId = $publicationId;
        $this->articleIds = $articleIds;
    }

    /**
     * @param string $publicationId
     * @param int[] $articleIds
     *
     * @return FindByIdsParameters
     */
    public static function createForPublicationAndArticleIds($publicationId, array $articleIds)
    {
        return new self($publicationId, $articleIds);
    }

    /**
     * @return string
     */
    public function getPublicationId()
    {
        return $this->publicationId;
    }

    /**
     * @return int[]
     */
    public function getArticleIds()
    {
        return $this->articleIds;
    }
}
