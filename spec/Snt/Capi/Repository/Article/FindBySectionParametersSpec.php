<?php

namespace spec\Snt\Capi\Repository\Article;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\Repository\Article\FindBySectionParameters;
use Snt\Capi\Repository\FindParametersInterface;

/**
 * @mixin FindBySectionParameters
 */
class FindBySectionParametersSpec extends ObjectBehavior
{
    const URL_PATTERN = 'publication/%s/sections/%s/latest';

    const PUBLICATION_ID = 'sa';

    const SECTION_NAME = 'bolig';

    const EMPTY_QUERY = '';

    function let()
    {
        $this->beConstructedThrough('createForPublicationIdAndSections', [self::PUBLICATION_ID, [self::SECTION_NAME]]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FindBySectionParameters::class);
        $this->shouldHaveType(FindParametersInterface::class);
    }

    function it_builds_url()
    {
        $path = sprintf(self::URL_PATTERN, self::PUBLICATION_ID, self::SECTION_NAME, self::EMPTY_QUERY);

        $path = rtrim($path, '?');

        $this->buildApiHttpPathAndQuery()->shouldBeLike(ApiHttpPathAndQuery::createForPath($path));
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
            ->setHotnessFrom(50)
            ->setHotnessTo(100)
            ->setLifetimeFrom(10)
            ->setLifetimeTo(30)
            ->setSince('2016-01-01')
            ->setUntil('2016-11-11');

        $path = sprintf(
            self::URL_PATTERN,
            self::PUBLICATION_ID,
            self::SECTION_NAME
        );

        $query = 'limit=10&offset=100&hotnessFrom=50&hotnessTo=100&lifetimeFrom=10&lifetimeTo=30&since=2016-01-01&until=2016-11-11';

        $this->buildApiHttpPathAndQuery()->shouldBeLike(ApiHttpPathAndQuery::createForPathAndQuery($path, $query));
    }

    function it_throws_exception_when_dates_are_incorrect()
    {
        $this->shouldThrow(InvalidArgumentException::class)->duringSetSince('invalid-date');
        $this->shouldThrow(InvalidArgumentException::class)->duringSetUntil('invalid-date');
        $this->shouldThrow(InvalidArgumentException::class)->duringSetLifetimeFrom(-1);
        $this->shouldThrow(InvalidArgumentException::class)->duringSetLifetimeFrom(-1);
        $this->shouldThrow(InvalidArgumentException::class)->duringSetHotnessFrom(101);
        $this->shouldThrow(InvalidArgumentException::class)->duringSetHotnessTo(120);
        $this->shouldThrow(InvalidArgumentException::class)->duringSetView('invalid-view');
    }
}
