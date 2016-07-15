<?php

namespace Snt\Capi\Repository\Article;

use Snt\Capi\Repository\TimeRangeParameter;

final class FindParameters
{
    const DEFAULT_SEPARATOR = ',';

    const QUERY_DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var string
     */
    private $publicationId;

    /**
     * @var int[]|null
     */
    private $articleIds;

    /**
     * @var int|null
     */
    private $articleId;

    /**
     * @var TimeRangeParameter|null
     */
    private $timeRange;

    /**
     * @var int|null
     */
    private $limit;

    private function __construct()
    {
    }

    /**
     * @param string $publicationId
     * @param TimeRangeParameter $timeRange
     * @param string $limit
     *
     * @return FindParameters
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
     *
     * @return FindParameters
     */
    public static function createForPublicationId($publicationId)
    {
        $self = new self();

        $self->publicationId = $publicationId;

        return $self;
    }

    /**
     * @param string $publicationId
     * @param string $articleId
     *
     * @return FindParameters
     */
    public static function createForPublicationIdAndArticleId($publicationId, $articleId)
    {
        $self = new self();

        $self->articleId = $articleId;
        $self->publicationId = $publicationId;

        return $self;
    }

    /**
     * @param string $publicationId
     * @param int[] $articleIds
     *
     * @return FindParameters
     */
    public static function createForPublicationIdAndArticleIds($publicationId, array $articleIds)
    {
        $self = new self();

        $self->publicationId = $publicationId;
        $self->articleIds = $articleIds;

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
     * @return int[]
     */
    public function getArticleIds()
    {
        return $this->articleIds;
    }

    /**
     * @return int
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * @return null|TimeRangeParameter
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
     * @return bool
     */
    public function hasArticleId()
    {
        return !is_null($this->articleId);
    }

    /**
     * @param string|null $separator
     *
     * @return string
     */
    public function buildArticleIdsString($separator = self::DEFAULT_SEPARATOR)
    {
        if (!is_null($this->articleId)) {
            return $this->articleId;
        } elseif (!is_null($this->articleIds)) {
            return implode($separator, $this->articleIds);
        }

        return '';
    }

    /**
     * @return string
     */
    public function buildQuery()
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
