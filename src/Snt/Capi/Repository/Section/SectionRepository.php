<?php

namespace Snt\Capi\Repository\Section;

use Snt\Capi\Http\Exception\ApiHttpClientException;
use Snt\Capi\Repository\AbstractRepository;
use Snt\Capi\Repository\FindParametersInterface;
use Snt\Capi\Repository\RepositoryDictionary;

class SectionRepository extends AbstractRepository implements SectionRepositoryInterface
{
    use RepositoryDictionary;

    /**
     * {@inheritdoc}
     */
    public function findAll(FindParametersInterface $findParameters)
    {
        $sectionsRawData = $this->fetch($findParameters);

        return isset($sectionsRawData['sections']) ? $sectionsRawData['sections'] : [];
    }

    /**
     * {@inheritdoc}
     */
    protected function handleExceptionForFindParameters(
        ApiHttpClientException $exception,
        FindParametersInterface $findParameters
    ) {
        $this->throwCouldNotFetchException($exception);
    }
}
