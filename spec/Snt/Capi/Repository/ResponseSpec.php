<?php

namespace spec\Snt\Capi\Repository;

use ArrayAccess;
use OutOfBoundsException;
use PhpSpec\ObjectBehavior;
use Snt\Capi\Repository\Response;

/**
 * @mixin Response
 */
class ResponseSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Response::class);
    }

    function it_implements_array_access()
    {
        $this->shouldImplement(ArrayAccess::class);
    }

    function it_returns_every_response_index_by_getter_call()
    {
        $indexValue = 4;

        $responseArray = [
            'index' => $indexValue,
        ];

        $this->beConstructedThroughCreateFrom($responseArray);

        $this->getIndex()->shouldReturn($indexValue);
    }

    function it_can_be_created_from_array()
    {
        $responseArray = [];

        $this->beConstructedThroughCreateFrom($responseArray);

        $this->toArray()->shouldReturn($responseArray);
    }

    function it_has_teasers()
    {
        $teasers = [
            [
                'id' => 12,
            ],
        ];

        $responseArray = [
            'teasers' => $teasers,
        ];

        $this->beConstructedThroughCreateFrom($responseArray);

        $this->getTeasers()->shouldReturn($teasers);
    }

    function it_has_articles()
    {
        $articles = [
            [
                'id' => 1,
            ],
            [
                'id' => 3,
            ],
        ];

        $responseArray = [
            'articles' => $articles,
        ];

        $this->beConstructedThroughCreateFrom($responseArray);

        $this->getArticles()->shouldReturn($articles);
    }

    function it_has_sections()
    {
        $sections = [
            [
                'id' => 1,
            ],
            [
                'id' => 3,
            ],
        ];

        $responseArray = [
            'sections' => $sections,
        ];

        $this->beConstructedThroughCreateFrom($responseArray);

        $this->getSections()->shouldReturn($sections);
    }

    function it_has_total()
    {
        $total = 2;

        $responseArray = [
            'total' => $total,
        ];

        $this->beConstructedThroughCreateFrom($responseArray);

        $this->getTotal()->shouldReturn($total);
    }

    function it_has_count()
    {
        $count = 2;

        $responseArray = [
            'count' => $count,
        ];

        $this->beConstructedThroughCreateFrom($responseArray);

        $this->getCount()->shouldReturn($count);
    }

    function it_throws_exception_when_response_index_does_not_exist()
    {
        $responseArray = [];

        $this->beConstructedThroughCreateFrom($responseArray);

        $this->shouldThrow(OutOfBoundsException::class)->duringGetNotExistingIndex();
    }

    function it_tells_when_was_created_from_null_response()
    {
        $this->beConstructedThroughCreateFrom(null);
        $this->shouldBeNull();

    }

    function it_tells_when_it_was_not_created_from_null_response()
    {
        $this->beConstructedThroughCreateFrom([]);
        $this->shouldNotBeNull();
    }
}
