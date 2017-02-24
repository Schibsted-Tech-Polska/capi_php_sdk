<?php

namespace spec\Snt\Capi\Repository\Article;

use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\PublicationId;
use Snt\Capi\Repository\Article\FindByIdsParameters;
use Snt\Capi\Repository\FindParametersInterface;

/**
 * @mixin FindByIdsParameters
 */
class FindByIdsParametersSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FindByIdsParameters::class);
        $this->shouldImplement(FindParametersInterface::class);
    }

    function it_creates_find_parameters_for_publication_id_and_article_ids()
    {
        $this->beConstructedThroughCreateForPublicationIdAndArticleIds(PublicationId::SA, [1, 2, 3]);

        $this->getPublicationId()->shouldReturn(PublicationId::SA);
        $this->getArticleIds()->shouldReturn([1, 2, 3]);
    }

    function it_builds_api_http_path_and_query()
    {
        $this->beConstructedThroughCreateForPublicationIdAndArticleIds(PublicationId::SA, [1, 2, 3, 4]);

        $path = sprintf('publication/%s/articles/%s', PublicationId::SA, '1,2,3,4');

        $expectedApiHttpPathAndQuery = ApiHttpPathAndQuery::createForPath($path);

        $this->buildApiHttpPathAndQuery()->shouldBeLike($expectedApiHttpPathAndQuery);
    }
}
