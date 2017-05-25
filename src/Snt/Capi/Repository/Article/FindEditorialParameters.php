<?php

namespace Snt\Capi\Repository\Article;

use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\Repository\FindParametersInterface;

final class FindEditorialParameters implements FindParametersInterface
{
    const ARTICLES_PATH_PATTERN = 'publication/%s/editorials/%s';

    /**
     * @var string
     */
    private $publicationId;

    /**
     * @var int|null
     */
    private $articleId;

    private function __construct()
    {
    }

    /**
     * @param string $publicationId
     * @param string $articleId
     *
     * @return FindEditorialParameters
     */
    public static function createForPublicationIdAndArticleId($publicationId, $articleId)
    {
        $self = new self();

        $self->articleId = $articleId;
        $self->publicationId = $publicationId;

        return $self;
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

    /**
     * {@inheritdoc}
     */
    public function buildApiHttpPathAndQuery()
    {
        $path = sprintf(
            self::ARTICLES_PATH_PATTERN,
            $this->publicationId,
            $this->articleId
        );

        return ApiHttpPathAndQuery::createForPath($path);
    }
}
