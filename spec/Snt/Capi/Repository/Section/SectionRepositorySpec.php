<?php

namespace spec\Snt\Capi\Repository\Section;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Snt\Capi\Http\Exception\ApiHttpClientException;
use Snt\Capi\Http\ApiHttpClientInterface;
use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\PublicationId;
use Snt\Capi\Repository\AbstractRepository;
use Snt\Capi\Repository\Exception\CouldNotFetchResourceRepositoryException;
use Snt\Capi\Repository\Response;
use Snt\Capi\Repository\Section\FindAllParameters;
use Snt\Capi\Repository\Section\SectionRepository;
use Snt\Capi\Repository\Section\SectionRepositoryInterface;

/**
 * @mixin SectionRepository
 */
class SectionRepositorySpec extends ObjectBehavior
{
    const SECTION_PATH_PATTERN = 'publication/%s/sections';

    function let(ApiHttpClientInterface $apiHttpClient)
    {
        $this->beConstructedWith($apiHttpClient);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AbstractRepository::class);
        $this->shouldHaveType(SectionRepository::class);
        $this->shouldImplement(SectionRepositoryInterface::class);
    }

    function it_finds_all_sections_for_publication_id(
        ApiHttpClientInterface $apiHttpClient
    ) {
        $expectedResponse = [
            'sections' => [
                ['title' => 'sport'],
                ['title' => 'kultur'],
            ],
        ];

        $path = sprintf(self::SECTION_PATH_PATTERN, PublicationId::SA);

        $apiHttpPathAndQuery = ApiHttpPathAndQuery::createForPath($path);

        $findParameters = FindAllParameters::createForPublicationId(PublicationId::SA);

        $apiHttpClient->get($apiHttpPathAndQuery)->shouldBeCalled()->willReturn('{"sections": [{"title":"sport"},{"title":"kultur"}]}');

        $this->findAll($findParameters)->shouldBeLike(Response::createFrom($expectedResponse));
    }

    function it_throws_exception_when_can_not_fetch_response_using_http_client(
        ApiHttpClientInterface $apiHttpClient
    ) {
        $apiHttpClient->get(Argument::type(ApiHttpPathAndQuery::class))->willThrow(ApiHttpClientException::class);

        $this
            ->shouldThrow(CouldNotFetchResourceRepositoryException::class)
            ->duringFindAll(
                FindAllParameters::createForPublicationId(PublicationId::SA)
            );
    }
}
