<?php

namespace spec\Snt\Capi\Repository\Section;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Snt\Capi\Http\Exception\HttpException;
use Snt\Capi\Http\HttpClientInterface;
use Snt\Capi\Http\HttpRequestParameters;
use Snt\Capi\PublicationId;
use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;
use Snt\Capi\Repository\Section\FindAllParameters;
use Snt\Capi\Repository\Section\SectionRepository;
use Snt\Capi\Repository\Section\SectionRepositoryInterface;

/**
 * @mixin SectionRepository
 */
class SectionRepositorySpec extends ObjectBehavior
{
    const SECTION_PATH_PATTERN = 'publication/%s/sections';

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

        $path = sprintf(self::SECTION_PATH_PATTERN, PublicationId::SA);

        $httpRequestParameters = HttpRequestParameters::createForPath($path);

        $findParameters = FindAllParameters::createForPublicationId(PublicationId::SA);

        $httpClient->get($httpRequestParameters)->shouldBeCalled()->willReturn('{"sections": [{"title":"sport"},{"title":"kultur"}]}');
        
        $this->findAll($findParameters)->shouldReturn($expectedSections);
    }

    function it_throws_exception_when_can_not_fetch_response_using_http_client(
        HttpClientInterface $httpClient
    ) {
        $httpClient->get(Argument::type(HttpRequestParameters::class))->willThrow(HttpException::class);

        $this
            ->shouldThrow(CouldNotFetchResourceRepositoryException::class)
            ->duringFindAll(
                FindAllParameters::createForPublicationId(PublicationId::SA)
            );
    }
}
