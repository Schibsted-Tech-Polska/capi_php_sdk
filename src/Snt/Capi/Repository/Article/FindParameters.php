<?php

namespace Snt\Capi\Repository\Article;

use Snt\Capi\Http\HttpRequestParameters;
use Snt\Capi\Repository\FindParametersInterface;

final class FindParameters implements FindParametersInterface
{
    const ARTICLES_PATH_PATTERN = 'publication/%s/articles/%s';

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
     * @return FindParameters
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
     * @return HttpRequestParameters
     */
    public function buildHttpRequestParameters()
    {
        $path = sprintf(
            self::ARTICLES_PATH_PATTERN,
            $this->publicationId,
            $this->articleId
        );

        return HttpRequestParameters::createForPath($path);
    }
}
