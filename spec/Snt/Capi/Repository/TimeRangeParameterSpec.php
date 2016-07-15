<?php

namespace spec\Snt\Capi\Repository;

use DateTime;
use PhpSpec\ObjectBehavior;
use Snt\Capi\Repository\TimeRangeParameter;

/**
 * @mixin TimeRangeParameter
 */
class TimeRangeParameterSpec extends ObjectBehavior
{
    function let(DateTime $since, DateTime $until)
    {
        $this->beConstructedWith($since, $until);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TimeRangeParameter::class);
    }

    function it_returns_information_about_since_and_until_dates(
        DateTime $since,
        DateTime $until
    ) {
        $this->getSince()->shouldReturn($since);
        $this->getUntil()->shouldReturn($until);
    }
}
