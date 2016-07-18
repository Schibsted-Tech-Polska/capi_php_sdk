<?php

namespace Snt\Capi\Repository\Article;

use Snt\Capi\Http\HttpRequestParameters;
use Snt\Capi\Repository\FindParametersInterface;

final class FindByIdsParameters implements FindParametersInterface
{
    const ARTICLES_PATH_PATTERN = 'publication/%s/articles/%s';

    const DEFAULT_SEPARATOR = ',';

    /**
     * @var string
     */
    private $publicationId;

    /**
     * @var int[]
     */
    private $articleIds;

    private function __construct()
    {
    }

    /**
     * @param string $publicationId
     * @param int[] $articleIds
     *
     * @return FindByIdsParameters
     */
    public static function createForPublicationIdAndArticleIds($publicationId, array $articleIds)
    {
        $self = new self();

        $self->publicationId = $publicationId;
        $self->articleIds = $articleIds;

        return $self;
    }

    /**
     * @return HttpRequestParameters
     */
    public function buildHttpRequestParameters()
    {
        $path = sprintf(
            self::ARTICLES_PATH_PATTERN,
            $this->publicationId,
            implode(self::DEFAULT_SEPARATOR, $this->articleIds)
        );

        return HttpRequestParameters::createForPath($path);
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
