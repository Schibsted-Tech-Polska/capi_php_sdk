<?php

namespace spec\Snt\Capi\Repository\Section;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Snt\Capi\Http\Exception\HttpException;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Repository\Section\Exception\CouldNotFetchSectionRepositoryException;
use Snt\Capi\Repository\Section\FindParameters;
use Snt\Capi\Repository\Section\SectionRepository;
use Snt\Capi\Repository\Section\SectionRepositoryInterface;

/**
 * @mixin SectionRepository
 */
class SectionRepositorySpec extends ObjectBehavior
{
    const SECTION_PATH_PATTERN = 'publication/%s/sections';

    const PUBLICATION_ID = 'sa';

    function let(HttpClientInterface $httpClient)
    {
        $this->beConstructedWith($httpClient);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SectionRepository::class);
        $this->shouldImplement(SectionRepositoryInterface::class);
    }

    function it_finds_all_sections_for_publication_id(
        HttpClientInterface $httpClient
    ) {
        $expectedSections = [
            ['title' => 'sport'],
            ['title' => 'kultur'],
        ];

        $findParameters = FindParameters::createForPublicationId(self::PUBLICATION_ID);

        $path = sprintf(self::SECTION_PATH_PATTERN, self::PUBLICATION_ID);

        $httpClient->get($path)->shouldBeCalled()->willReturn('{"sections": [{"title":"sport"},{"title":"kultur"}]}');
        
        $this->findAll($findParameters)->shouldReturn($expectedSections);
    }

    function it_throws_exception_when_can_not_fetch_response_using_http_client(
        HttpClientInterface $httpClient
    ) {
        $httpClient->get(Argument::any())->willThrow(HttpException::class);

        $this
            ->shouldThrow(CouldNotFetchSectionRepositoryException::class)
            ->duringFindAll(
                FindParameters::createForPublicationId(self::PUBLICATION_ID)
            );
    }
}
