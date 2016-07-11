<?php

namespace Snt\Capi\Repository;

use Snt\Capi\Entity\Article;
use Snt\Capi\Http\HttpClientInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
    const ARTICLE_PATH_PATTERN = 'publication/%s/articles/%s';

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $publicationId;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(
        HttpClientInterface $httpClient
    ) {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $publicationId
     */
    public function setPublicationId($publicationId)
    {
        $this->publicationId = $publicationId;
    }

    /**
     * {@inheritdoc}
     */
    public function find($publicationId, $articleId)
    {
        $articleRawData = json_decode(
            $this->httpClient->get(
                $this->buildPath($publicationId, $articleId)
            ),
            true
        );

        return new Article($articleRawData);
    }

    private function buildPath($publicationId, $articleId)
    {
        return sprintf(self::ARTICLE_PATH_PATTERN, $publicationId, $articleId);
    }
}
