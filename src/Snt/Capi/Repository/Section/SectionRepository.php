<?php

namespace Snt\Capi\Repository\Section;

use Snt\Capi\Http\Exception\HttpException;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;
use Snt\Capi\Repository\FindParametersInterface;

class SectionRepository implements SectionRepositoryInterface
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(FindParametersInterface $findParameters)
    {
        try {
            $sectionsRawData = json_decode(
                $this->httpClient->get(
                    $findParameters->buildHttpRequestParameters()
                ),
                true
            );
        } catch (HttpException $exception) {
            throw new CouldNotFetchResourceRepositoryException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return isset($sectionsRawData['sections']) ? $sectionsRawData['sections'] : [];
    }
}
