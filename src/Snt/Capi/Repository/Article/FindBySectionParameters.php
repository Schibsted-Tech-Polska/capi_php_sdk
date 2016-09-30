<?php

namespace Snt\Capi\Repository\Article;

use DateTime;
use Exception;
use InvalidArgumentException;
use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\Repository\FindParametersInterface;

class FindBySectionParameters implements FindParametersInterface
{
    const URL_PATTERN = 'publication/%s/sections/%s/latest';

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

    private function __construct()
    {
    }

    /**
     * @param string $publicationId
     * @param string[] $sections
     *
     * @return FindBySectionParameters
     */
    public static function createForPublicationIdAndSections($publicationId, array $sections)
    {
        $self = new self();

        $self->publicationId = $publicationId;
        $self->sections = $sections;

        return $self;
    }

    /**
     * {@inheritdoc}
     */
    public function buildApiHttpPathAndQuery()
    {
        $path = sprintf(
            static::URL_PATTERN,
            $this->publicationId,
            implode(',', $this->sections)
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
        if (!in_array($view, ['min', 'teaser'])) {
            throw new InvalidArgumentException(
                sprintf('Value "%s" is not allowed. Allowed are "min", "teaser"', $view)
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
            $this->parameters['since'] = $date->format('YYYY-mm-dd');
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
            $this->parameters['until'] = $date->format('YYYY-mm-dd');
        } catch (Exception $e) {
            throw new InvalidArgumentException(sprintf('Argument "%s" is not a valid date', $until), 0, $e);
        }

        return $this;
    }

    /**
     * @param int $hotnessFrom
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setHotnessFrom($hotnessFrom)
    {
        $hotnessFrom = (int) $hotnessFrom;
        if (!$this->isArticleValueValid($hotnessFrom)) {
            throw new InvalidArgumentException(sprintf('Argument "%s" should be from [0; 100] range', $hotnessFrom));
        }

        $this->parameters['hotnessFrom'] = $hotnessFrom;

        return $this;
    }

    /**
     * @param int $hotnessTo
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setHotnessTo($hotnessTo)
    {
        $hotnessTo = (int) $hotnessTo;
        if (!$this->isArticleValueValid($hotnessTo)) {
            throw new InvalidArgumentException(sprintf('Argument "%s" should be from [0; 100] range', $hotnessTo));
        }

        $this->parameters['hotnessTo'] = $hotnessTo;

        return $this;
    }

    /**
     * @param int $lifetimeFrom
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setLifetimeFrom($lifetimeFrom)
    {
        $lifetimeFrom = (int)$lifetimeFrom;
        if (!$this->isArticleValueValid($lifetimeFrom)) {
            throw new InvalidArgumentException(sprintf('Argument "%s" should be from [0; 100] range', $lifetimeFrom));
        }

        $this->parameters['lifetimeFrom'] = $lifetimeFrom;

        return $this;
    }

    /**
     * @param int $lifetimeTo
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setLifetimeTo($lifetimeTo)
    {
        $lifetimeTo = (int)$lifetimeTo;
        if (!$this->isArticleValueValid($lifetimeTo)) {
            throw new InvalidArgumentException(sprintf('Argument "%s" should be from [0; 100] range', $lifetimeTo));
        }

        $this->parameters['lifetimeTo'] = $lifetimeTo;

        return $this;
    }

    /**
     * @param int $value
     *
     * @return bool
     */
    private function isArticleValueValid($value)
    {
        return $value >= 0 && $value <= 100;
    }
}
