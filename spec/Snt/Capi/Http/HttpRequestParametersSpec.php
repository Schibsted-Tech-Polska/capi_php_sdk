<?php

namespace spec\Snt\Capi\Http;

use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\HttpRequestParameters;

/**
 * @mixin HttpRequestParameters
 */
class HttpRequestParametersSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(HttpRequestParameters::class);
    }

    function it_creates_request_parameters_using_path()
    {
        $this->beConstructedThrough('createForPath', ['path']);

        $this->getPath()->shouldReturn('path');
    }

    function it_creates_request_parameters_using_path_and_query()
    {
        $this->beConstructedThrough('createForPathAndQuery', ['path', 'query']);

        $this->getPath()->shouldReturn('path');
        $this->getQuery()->shouldReturn('query');
    }
}
