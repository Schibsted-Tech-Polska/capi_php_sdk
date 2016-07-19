<?php

namespace Snt\Capi\Repository\Article;

use DateTime;
use Exception;
use Snt\Capi\Http\HttpRequestParameters;
use Snt\Capi\Repository\FindParametersInterface;
use Snt\Capi\Repository\TimeRangeParameter;

final class FindByChangelogParameters implements FindParametersInterface
{
    const ARTICLES_CHANGELOG_PATTERN = 'changelog/%s/search';

    const QUERY_DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var string
     */
    private $publicationId;

    /**
     * @var TimeRangeParameter|null
     */
    private $timeRange;

    /**
     * @var string|null
     */
    private $limit;

    /**
     * @var string|null
     */
    private $offset;

    private function __construct()
    {
    }

    /**
     * @param string $publicationId
     * @param array $parameters
     *
     * @return FindByChangelogParameters
     * @throws Exception
     */
    public static function createForPublicationIdFromArray($publicationId, array $parameters)
    {
        $acceptedParameters = [
            'limit',
            'offset',
        ];
        
        $self = new self();
        $self->publicationId = $publicationId;

        if (isset($parameters['since'], $parameters['until'])) {
            $self->timeRange = new TimeRangeParameter(
                new DateTime($parameters['since']),
                new DateTime($parameters['until'])
            );
        }

        foreach ($acceptedParameters as $allowedKey) {
            if (isset($parameters[$allowedKey])) {
                $self->$allowedKey = $parameters[$allowedKey];
            }
        }

        return $self;
    }

    /**
     * @param string $publicationId
     *
     * @return FindByChangelogParameters
     */
    public static function createForPublicationId($publicationId)
    {
        $self = new self();

        $self->publicationId = $publicationId;

        return $self;
    }

    /**
     * @param string $publicationId
     * @param TimeRangeParameter $timeRange
     * @param string $limit
     *
     * @return FindByChangelogParameters
     */
    public static function createForPublicationIdWithTimeRangeAndLimit(
        $publicationId,
        TimeRangeParameter $timeRange,
        $limit
    ) {
        $self = new self();

        $self->publicationId = $publicationId;
        $self->timeRange = $timeRange;
        $self->limit = $limit;

        return $self;
    }

    /**
     * @param string $publicationId
     * @param TimeRangeParameter $timeRange
     * @param string $limit
     * @param string $offset
     *
     * @return FindByChangelogParameters
     */
    public static function createForPublicationIdWithTimeRangeAndLimitAndOffset(
        $publicationId,
        TimeRangeParameter $timeRange,
        $limit,
        $offset
    ) {
        $self = new self();

        $self->publicationId = $publicationId;
        $self->timeRange = $timeRange;
        $self->limit = $limit;
        $self->offset = $offset;

        return $self;
    }

    /**
     * @return string|null
     */
    public function getPublicationId()
    {
        return $this->publicationId;
    }

    /**
     * @return TimeRangeParameter|null
     */
    public function getTimeRange()
    {
        return $this->timeRange;
    }

    /**
     * @return string|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return string|null
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return HttpRequestParameters
     */
    public function buildHttpRequestParameters()
    {
        $path = sprintf(
            self::ARTICLES_CHANGELOG_PATTERN,
            $this->publicationId
        );

        return HttpRequestParameters::createForPathAndQuery($path, $this->buildQuery());
    }

    private function buildQuery()
    {
        $query = [];

        if (!is_null($this->limit)) {
            $query['limit'] = $this->limit;
        }

        if (!is_null($this->offset)) {
            $query['offset'] = $this->offset;
        }

        if ($this->timeRange instanceof TimeRangeParameter) {
            $query['since'] = $this->timeRange->getSince()->format(self::QUERY_DATETIME_FORMAT);
            $query['until'] = $this->timeRange->getUntil()->format(self::QUERY_DATETIME_FORMAT);
        }

        return http_build_query($query);
    }
}
