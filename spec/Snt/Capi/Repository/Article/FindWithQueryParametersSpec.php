<?php

namespace spec\Snt\Capi\Repository\Article;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\Repository\Article\FindWithQueryParameters;
use Snt\Capi\Repository\FindParametersInterface;

/**
 * @mixin FindWithQueryParameters
 */
class FindWithQueryParametersSpec extends ObjectBehavior
{
    const PUBLICATION_ID = 'sa';

    const QUERY = 'mablis';

    const URL_PATTERN = 'publication/%s/searchContents/search';

    function let()
    {
        $this->beConstructedThroughCreateForPublicationIdAndQuery(self::PUBLICATION_ID, self::QUERY);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FindWithQueryParameters::class);
        $this->shouldHaveType(FindParametersInterface::class);
    }

    function it_builds_url()
    {
        $path = sprintf(self::URL_PATTERN, self::PUBLICATION_ID);

        $query = 'query=mablis';

        $this->buildApiHttpPathAndQuery()->shouldBeLike(ApiHttpPathAndQuery::createForPathAndQuery($path, $query));
    }

    function it_sets_view()
    {
        $this->shouldNotThrow(InvalidArgumentException::class)->duringSetView('min');
        $this->shouldNotThrow(InvalidArgumentException::class)->duringSetView('entire');
        $this->shouldNotThrow(InvalidArgumentException::class)->duringSetView('teaser');
    }

    function it_builds_api_http_path_and_query()
    {
        $this->setLimit(10)
            ->setOffset(100)
            ->setSince('2016-01-01')
            ->setUntil('2016-11-11');

        $path = sprintf(
            self::URL_PATTERN,
            self::PUBLICATION_ID
        );

        $query = 'query=mablis&limit=10&offset=100&since=2016-01-01&until=2016-11-11';

        $this->buildApiHttpPathAndQuery()->shouldBeLike(ApiHttpPathAndQuery::createForPathAndQuery($path, $query));
    }

    function it_throws_exception_when_dates_are_incorrect()
    {
        $this->shouldThrow(InvalidArgumentException::class)->duringSetSince('invalid-date');
        $this->shouldThrow(InvalidArgumentException::class)->duringSetUntil('invalid-date');
    }
}
