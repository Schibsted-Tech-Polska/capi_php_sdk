<?php

namespace spec\Snt\Capi\Repository\Article;

use DateTime;
use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\PublicationId;
use Snt\Capi\Repository\Article\FindByChangelogParameters;
use Snt\Capi\Repository\FindParametersInterface;
use Snt\Capi\Repository\TimeRangeParameter;

/**
 * @mixin FindByChangelogParameters
 */
class FindByChangelogParametersSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FindByChangelogParameters::class);
        $this->shouldImplement(FindParametersInterface::class);
    }

    function it_creates_find_parameters_for_publication_id()
    {
        $this->beConstructedThroughCreateForPublicationId(PublicationId::FVN);

        $this->getPublicationId()->shouldReturn(PublicationId::FVN);
    }

    function it_creates_find_parameters_from_array_for_publication_id()
    {
        $inputArray = [
            'limit' => 2,
            'offset' => 3,
            'since' => '2015-01-01',
            'until' => '2015-02-02',
        ];

        $this->beConstructedThroughCreateForPublicationIdFromArray(PublicationId::AP, $inputArray);

        $this->getPublicationId()->shouldReturn(PublicationId::AP);
        $this->getOffset()->shouldReturn(3);
        $this->getLimit()->shouldReturn(2);
        $this->getTimeRange()->getSince()->shouldBeLike(new DateTime('2015-01-01'));
        $this->getTimeRange()->getUntil()->shouldBeLike(new DateTime('2015-02-02'));
    }

    function it_creates_find_parameters_for_publication_id_with_time_range_and_limit()
    {
        $timeRange = new TimeRangeParameter(
            new DateTime('2016-01-01'),
            new DateTime('2016-02-01')
        );
        $limit = 2;

        $this->beConstructedThroughCreateForPublicationIdWithTimeRangeAndLimit(PublicationId::AP, $timeRange, $limit);

        $this->getPublicationId()->shouldReturn(PublicationId::AP);
        $this->getTimeRange()->shouldReturn($timeRange);
        $this->getLimit()->shouldReturn($limit);
    }

    function it_creates_find_parameters_for_publication_id_with_time_range_and_limit_and_offset()
    {
        $timeRange = new TimeRangeParameter(
            new DateTime('2016-01-01'),
            new DateTime('2016-02-01')
        );
        $limit = 2;
        $offset = 2;

        $this->beConstructedThroughCreateForPublicationIdWithTimeRangeAndLimitAndOffset(PublicationId::AP, $timeRange, $limit, $offset);

        $this->getPublicationId()->shouldReturn(PublicationId::AP);
        $this->getTimeRange()->shouldReturn($timeRange);
        $this->getLimit()->shouldReturn($limit);
        $this->getOffset()->shouldReturn($offset);
    }

    function it_builds_api_http_path_and_query()
    {
        $timeRange = new TimeRangeParameter(
            new DateTime('2016-03-01'),
            new DateTime('2016-04-01')
        );
        $limit = 5;

        $this->beConstructedThroughCreateForPublicationIdWithTimeRangeAndLimit(PublicationId::AP, $timeRange, $limit);

        $path = sprintf('changelog/%s/search', PublicationId::AP);

        $expectedApiHttpPathAndQuery = ApiHttpPathAndQuery::createForPathAndQuery($path, 'limit=5&since=2016-03-01+00%3A00%3A00&until=2016-04-01+00%3A00%3A00');

        $this->buildApiHttpPathAndQuery()->shouldBeLike($expectedApiHttpPathAndQuery);
    }
}
