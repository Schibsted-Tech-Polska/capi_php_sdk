<?php

namespace Snt\Capi\Repository\Article;

use Snt\Capi\Http\Exception\HttpException;
use Snt\Capi\Repository\AbstractRepository;
use Snt\Capi\Repository\FindParametersInterface;

class ArticleRepository extends AbstractRepository implements ArticleRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function find(FindParametersInterface $findParameters)
    {
        try {
            $articleRawData = json_decode($this->makeHttpGetRequest($findParameters), true);
        } catch (HttpException $exception) {
            if ($exception->isNotFoundError()) {
                return null;
            }

            $this->throwCouldNotFetchException($exception);
        }

        return $articleRawData;
    }

    /**
     * {@inheritdoc}
     */
    public function findByIds(FindParametersInterface $findParameters)
    {
        try {
            $articlesRawData = json_decode($this->makeHttpGetRequest($findParameters), true);
        } catch (HttpException $exception) {
            $this->throwCouldNotFetchException($exception);
        }

        return isset($articlesRawData['articles']) ? $articlesRawData['articles'] : [];
    }

    /**
     * {@inheritdoc}
     */
    public function findByChangelog(FindParametersInterface $findParameters)
    {
        try {
            $articlesChangelogRawData = json_decode($this->makeHttpGetRequest($findParameters), true);
        } catch (HttpException $exception) {
            $this->throwCouldNotFetchException($exception);
        }

        return $articlesChangelogRawData;
    }
}
