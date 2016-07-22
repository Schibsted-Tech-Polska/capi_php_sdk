<?php

namespace spec\Snt\Capi\Http;

use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\ApiHttpPathAndQuery;

/**
 * @mixin ApiHttpPathAndQuery
 */
class ApiHttpPathAndQuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ApiHttpPathAndQuery::class);
    }

    function it_creates_api_http_path_and_query_using_path()
    {
        $this->beConstructedThrough('createForPath', ['path']);

        $this->getPath()->shouldReturn('path');
    }

    function it_creates_api_http_path_and_query_using_both_of_them()
    {
        $this->beConstructedThrough('createForPathAndQuery', ['path', 'query']);

        $this->getPath()->shouldReturn('path');
        $this->getQuery()->shouldReturn('query');
    }

    function it_returns_path_and_query_concatenation()
    {
        $this->beConstructedThrough('createForPathAndQuery', ['path', 'query']);

        $this->getPathAndQuery()->shouldReturn('path?query');
    }
}
