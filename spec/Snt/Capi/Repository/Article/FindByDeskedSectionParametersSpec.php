<?php

namespace spec\Snt\Capi\Repository\Article;

use PhpSpec\ObjectBehavior;
use Snt\Capi\PublicationId;
use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\Repository\Article\FindByDeskedSectionParameters;
use Snt\Capi\Repository\Article\FindBySectionParameters;
use Snt\Capi\Repository\FindParametersInterface;

/**
 * @mixin FindByDeskedSectionParameters
 */
class FindByDeskedSectionParametersSpec extends ObjectBehavior
{
    const DEFAULT_DESKED_SECTION = 'forsiden';

    const URL_PATTERN = 'publication/%s/sections/%s/desked';

    function let()
    {
        $this->beConstructedThrough(
            'createForPublicationIdAndSections',
            [PublicationId::SA, [self::DEFAULT_DESKED_SECTION]]
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FindByDeskedSectionParameters::class);
        $this->shouldHaveType(FindParametersInterface::class);
        $this->shouldHaveType(FindBySectionParameters::class);
    }

    function it_builds_url()
    {
        $path = sprintf(self::URL_PATTERN, PublicationId::SA, self::DEFAULT_DESKED_SECTION);

        $this->buildApiHttpPathAndQuery()->shouldBeLike(ApiHttpPathAndQuery::createForPath($path));
    }

    function it_builds_api_http_path_and_query()
    {
        $this->setLimit(10)->setOffset(100);

        $path = sprintf(self::URL_PATTERN, PublicationId::SA, self::DEFAULT_DESKED_SECTION);
        $query = 'limit=10&offset=100';

        $this->buildApiHttpPathAndQuery()->shouldBeLike(ApiHttpPathAndQuery::createForPathAndQuery($path, $query));
    }
}
