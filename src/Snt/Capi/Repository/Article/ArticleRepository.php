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

    public function find(FindParameters $findParameters)
    {
        return $this->fetch($findParameters);
    }

    public function findByIds(FindByIdsParameters $findParameters)
    {
        return $this->fetch($findParameters);
    }

    public function findByChangelog(FindByChangelogParameters $findParameters)
    {
        return $this->fetch($findParameters);
    }

    public function findBySections(FindBySectionParameters $findParameters)
    {
        return $this->fetch($findParameters);
    }

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
