<?php

namespace Snt\Capi\Repository;

use Snt\Capi\Entity\Article;
use Snt\Capi\Http\Exception\CouldNotMakeHttpGetRequest;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Repository\Exception\CouldNotFetchArticleException;

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
    public function find($articleId)
    {
        try {
            $articleRawData = json_decode(
                $this->httpClient->get(
                    $this->buildPath($articleId)
                ),
                true
            );
        } catch (CouldNotMakeHttpGetRequest $exception) {
            throw new CouldNotFetchArticleException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return new Article($articleRawData);
    }

    private function buildPath($articleId)
    {
        return sprintf(self::ARTICLE_PATH_PATTERN, $this->publicationId, $articleId);
    }
}
