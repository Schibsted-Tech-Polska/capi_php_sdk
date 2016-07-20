<?php

namespace Snt\Capi\Repository\Section;

use Snt\Capi\Http\Exception\ApiHttpClientException;
use Snt\Capi\Repository\AbstractRepository;
use Snt\Capi\Repository\FindParametersInterface;

class SectionRepository extends AbstractRepository implements SectionRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findAll(FindParametersInterface $findParameters)
    {
        try {
            $sectionsRawData = json_decode($this->makeHttpGetRequest($findParameters), true);
        } catch (ApiHttpClientException $exception) {
            $this->throwCouldNotFetchException($exception);
        }

        return isset($sectionsRawData['sections']) ? $sectionsRawData['sections'] : [];
    }
}
