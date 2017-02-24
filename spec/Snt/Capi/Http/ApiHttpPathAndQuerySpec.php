<?php

namespace spec\Snt\Capi\Http;

use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\ApiHttpPathAndQuery;

/**
 * @mixin ApiHttpPathAndQuery
 */
class ApiHttpPathAndQuerySpec extends ObjectBehavior
{
    const PATH = 'path';

    const QUERY = 'query';

    function it_is_initializable()
    {
        $this->shouldHaveType(ApiHttpPathAndQuery::class);
    }

    function it_creates_api_http_path_and_query_using_path()
    {
        $this->beConstructedThroughCreateForPath(self::PATH);

        $this->getPath()->shouldReturn(self::PATH);
    }

    function it_creates_api_http_path_and_query_using_both_of_them()
    {
        $this->beConstructedThroughCreateForPathAndQuery(self::PATH, self::QUERY);

        $this->getPath()->shouldReturn(self::PATH);
        $this->getQuery()->shouldReturn(self::QUERY);
    }

    function it_returns_path_and_query_concatenation()
    {
        $this->beConstructedThroughCreateForPathAndQuery(self::PATH, self::QUERY);

        $this->getPathAndQuery()->shouldReturn('path?query');
    }
}
