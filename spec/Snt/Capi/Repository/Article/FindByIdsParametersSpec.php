<?php

namespace spec\Snt\Capi\Repository\Article;

use PhpSpec\ObjectBehavior;
use Snt\Capi\Http\HttpRequestParameters;
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
        $this->beConstructedThrough('createForPublicationIdAndArticleIds', [PublicationId::SA, [1, 2, 3]]);

        $this->getPublicationId()->shouldReturn(PublicationId::SA);
        $this->getArticleIds()->shouldReturn([1, 2, 3]);
    }

    function it_builds_http_request_parameters()
    {
        $this->beConstructedThrough('createForPublicationIdAndArticleIds', [PublicationId::SA, [1, 2, 3, 4]]);

        $path = sprintf('publication/%s/articles/%s', PublicationId::SA, '1,2,3,4');

        $expectedHttpRequestParameters = HttpRequestParameters::createForPath($path);

        $this->buildHttpRequestParameters()->shouldBeLike($expectedHttpRequestParameters);
    }
}
