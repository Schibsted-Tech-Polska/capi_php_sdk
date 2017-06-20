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
        $this->beConstructedThroughCreateForPublicationIdAndSections(self::PUBLICATION_ID, [self::SECTION_NAME]);
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

    function it_returns_parameters()
    {
        $view = FindBySectionParameters::VIEW_ENTIRE;
        $offset = 80;
        $limit = 40;
        $since = '2014-12-07';
        $until = '2017-01-05';
        $hotnessFrom = 10;
        $hotnessTo = 30;
        $lifetimeFrom = 40;
        $lifetimeTo = 50;

        $this->setView($view);
        $this->setOffset($offset);
        $this->setLimit($limit);
        $this->setSince($since);
        $this->setUntil($until);
        $this->setHotnessFrom($hotnessFrom);
        $this->setHotnessTo($hotnessTo);
        $this->setLifetimeFrom($lifetimeFrom);
        $this->setLifetimeTo($lifetimeTo);

        $this->getPublicationId()->shouldReturn(self::PUBLICATION_ID);
        $this->getSections()->shouldReturn([self::SECTION_NAME]);
        $this->getView()->shouldReturn($view);
        $this->getOffset()->shouldReturn($offset);
        $this->getLimit()->shouldReturn($limit);
        $this->getSince()->shouldReturn($since);
        $this->getUntil()->shouldReturn($until);
        $this->getHotnessFrom()->shouldReturn($hotnessFrom);
        $this->getHotnessTo()->shouldReturn($hotnessTo);
        $this->getLifetimeFrom()->shouldReturn($lifetimeFrom);
        $this->getLifetimeTo()->shouldReturn($lifetimeTo);
    }

    function it_returns_nulls_when_parameters_are_not_set()
    {
        $this->getView()->shouldReturn(null);
        $this->getOffset()->shouldReturn(null);
        $this->getLimit()->shouldReturn(null);
        $this->getSince()->shouldReturn(null);
        $this->getUntil()->shouldReturn(null);
        $this->getHotnessFrom()->shouldReturn(null);
        $this->getHotnessTo()->shouldReturn(null);
        $this->getLifetimeFrom()->shouldReturn(null);
        $this->getLifetimeTo()->shouldReturn(null);
    }
}
