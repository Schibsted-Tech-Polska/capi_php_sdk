<?php

namespace Snt\Capi\Repository\Article;

use Snt\Capi\Http\Exception\ApiHttpClientException;
use Snt\Capi\Http\Exception\ApiHttpClientNotFoundException;
use Snt\Capi\Repository\AbstractRepository;
use Snt\Capi\Repository\FindParametersInterface;
use Snt\Capi\Repository\RepositoryDictionary;

class ArticleRepository extends AbstractRepository implements ArticleRepositoryInterface
{
    use RepositoryDictionary;

    /**
     * {@inheritdoc}
     */
    public function find(FindParameters $findParameters)
    {
        return $this->fetch($findParameters);
    }

    /**
     * {@inheritdoc}
     */
    public function findByIds(FindByIdsParameters $findParameters)
    {
        $articlesRawData = $this->fetch($findParameters);

        if (isset($articlesRawData['articles'])) {
            return $articlesRawData['articles'];
        } elseif (!is_null($articlesRawData)) {
            return [$articlesRawData];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function findByChangelog(FindByChangelogParameters $findParameters)
    {
        return $this->fetch($findParameters);
    }

    /**
     * {@inheritdoc}
     */
    public function findBySections(FindBySectionParameters $findParameters)
    {
        $articlesRawData = $this->fetch($findParameters);

        return isset($articlesRawData['teasers']) ? $articlesRawData['teasers'] : [];
    }

    /**
     * {@inheritdoc}
     */
    protected function handleExceptionForFindParameters(
        ApiHttpClientException $exception,
        FindParametersInterface $findParameters
    ) {
        if ($exception instanceof ApiHttpClientNotFoundException) {
            return null;
        }

        $this->throwCouldNotFetchException($exception);
    }
}
