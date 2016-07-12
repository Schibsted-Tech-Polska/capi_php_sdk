<?php

namespace Snt\Capi\Repository\Article;

final class FindParameters
{
    /**
     * @var string
     */
    private $publicationId;

    /**
     * @var int
     */
    private $articleId;

    /**
     * @param string $publicationId
     * @param int $articleId
     */
    private function __construct($publicationId, $articleId)
    {
        $this->publicationId = $publicationId;
        $this->articleId = $articleId;
    }

    /**
     * @param string $publicationId
     * @param string $articleId
     *
     * @return FindParameters
     */
    public static function createForPublicationAndArticleId($publicationId, $articleId)
    {
        return new self($publicationId, $articleId);
    }

    /**
     * @return string
     */
    public function getPublicationId()
    {
        return $this->publicationId;
    }

    /**
     * @return int
     */
    public function getArticleId()
    {
        return $this->articleId;
    }
}
