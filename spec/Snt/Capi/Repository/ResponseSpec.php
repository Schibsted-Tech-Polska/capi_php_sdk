<?php

namespace spec\Snt\Capi\Repository;

use ArrayAccess;
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

    function it_can_be_created_from_array()
    {
        $responseArray = [];

        $this->beConstructedThrough('createFrom', [$responseArray]);

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

        $this->beConstructedThrough('createFrom', [$responseArray]);

        $this->getTeasers()->shouldReturn($teasers);
    }

    function it_has_articles()
    {
        function it_has_teasers()
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

            $this->beConstructedThrough('createFrom', [$responseArray]);

            $this->getArticles()->shouldReturn($articles);
        }
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

        $this->beConstructedThrough('createFrom', [$responseArray]);

        $this->getSections()->shouldReturn($sections);
    }

    function it_has_total()
    {
        $total = 2;

        $responseArray = [
            'total' => $total,
        ];

        $this->beConstructedThrough('createFrom', [$responseArray]);

        $this->getTotal()->shouldReturn($total);
    }

    function it_has_count()
    {
        $count = 2;

        $responseArray = [
            'count' => $count,
        ];

        $this->beConstructedThrough('createFrom', [$responseArray]);

        $this->getCount()->shouldReturn($count);
    }
}
