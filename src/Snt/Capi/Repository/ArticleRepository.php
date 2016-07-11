<?php

namespace Snt\Capi\Repository;

use Snt\Capi\Entity\Article;
use Snt\Capi\Http\Exception\CouldNotMakeHttpGetRequest;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Repository\Exception\CouldNotFetchArticleException;

class ArticleRepository implements ArticleRepositoryInterface
{
    const ARTICLES_PATH_PATTERN = 'publication/%s/articles/%s';

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
                    $this->buildPath([$articleId])
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

    /**
     * {@inheritdoc}
     */
    public function findByIds(array $articleIds)
    {
        $articleCollection = [];

        try {
            $articlesRawData = json_decode(
                $this->httpClient->get(
                    $this->buildPath($articleIds)
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

        foreach ($articlesRawData['articles'] as $articleRawData) {
            $articleCollection[] = new Article($articleRawData);
        }

        return $articleCollection;
    }

    private function buildPath(array $articleIds)
    {
        return sprintf(self::ARTICLES_PATH_PATTERN, $this->publicationId, implode(',', $articleIds));
    }
}
