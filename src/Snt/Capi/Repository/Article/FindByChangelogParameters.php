<?php

namespace Snt\Capi\Repository\Article;

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
     * @var TimeRangeParameter
     */
    private $timeRange;

    /**
     * @var int
     */
    private $limit;

    private function __construct()
    {
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
     * @return string
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
     * @return int|null
     */
    public function getLimit()
    {
        return $this->limit;
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

        if ($this->timeRange instanceof TimeRangeParameter) {
            $query['since'] = $this->timeRange->getSince()->format(self::QUERY_DATETIME_FORMAT);
            $query['until'] = $this->timeRange->getUntil()->format(self::QUERY_DATETIME_FORMAT);
        }

        return http_build_query($query);
    }
}
