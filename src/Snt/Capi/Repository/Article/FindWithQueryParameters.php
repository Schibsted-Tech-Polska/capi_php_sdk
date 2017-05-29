<?php

namespace Snt\Capi\Repository\Article;

use DateTime;
use Exception;
use InvalidArgumentException;
use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\Repository\FindParametersInterface;

class FindWithQueryParameters implements FindParametersInterface
{
    const URL_PATTERN = 'publication/%s/searchContents/search';

    const VIEW_MIN = 'min';
    const VIEW_TEASER = 'teaser';
    const VIEW_ENTIRE = 'entire';

    /**
     * @var string
     */
    protected $publicationId;

    /**
     * @var string[]
     */
    protected $sections;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var string
     */
    protected $query;

    private function __construct()
    {
    }

    /**
     * @param string $publicationId
     * @param string $query
     *
     * @return FindWithQueryParameters
     */
    public static function createForPublicationIdAndQuery($publicationId, $query)
    {
        $self = new self();

        $self->publicationId = $publicationId;
        $self->parameters['query'] = $query;

        return $self;
    }

    /**
     * {@inheritDoc}
     */
    public function buildApiHttpPathAndQuery()
    {
        $path = sprintf(
            static::URL_PATTERN,
            $this->publicationId
        );

        $query = http_build_query($this->parameters);

        return ApiHttpPathAndQuery::createForPathAndQuery($path, $query);
    }

    /**
     * @param string $view
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setView($view)
    {
        if (!in_array($view, [self::VIEW_MIN, self::VIEW_TEASER, self::VIEW_ENTIRE])) {
            throw new InvalidArgumentException(
                sprintf('Value "%s" is not allowed. Allowed are "min", "teaser", "entire"', $view)
            );
        }

        $this->parameters['view'] = $view;

        return $this;
    }

    /**
     * @param int $offset
     *
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->parameters['offset'] = (int) $offset;

        return $this;
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->parameters['limit'] = (int) $limit;

        return $this;
    }

    /**
     * @param string $since
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setSince($since)
    {
        try {
            $date = new DateTime($since);
            $this->parameters['since'] = $date->format('Y-m-d');
        } catch (Exception $e) {
            throw new InvalidArgumentException(sprintf('Argument "%s" is not a valid date', $since), 0, $e);
        }

        return $this;
    }

    /**
     * @param string $until
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setUntil($until)
    {
        try {
            $date = new DateTime($until);
            $this->parameters['until'] = $date->format('Y-m-d');
        } catch (Exception $e) {
            throw new InvalidArgumentException(sprintf('Argument "%s" is not a valid date', $until), 0, $e);
        }

        return $this;
    }

    /**
     * @param string $filter
     */
    public function setFilter($filter)
    {
        $this->parameters['filter'] = $filter;
    }
}
