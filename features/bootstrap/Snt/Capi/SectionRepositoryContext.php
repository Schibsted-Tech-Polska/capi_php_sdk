<?php

namespace Snt\Capi;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Mockery;
use PHPUnit_Framework_ExpectationFailedException as PhpUnitExpectationFailedException;
use PHPUnit_Framework_TestCase as PhpUnit;
use Snt\Capi\Http\ApiHttpClientInterface;
use Snt\Capi\Http\ApiHttpPathAndQuery;
use Snt\Capi\Repository\Section\FindAllParameters;
use Snt\Capi\Repository\Section\SectionRepository;
use Snt\Capi\Repository\Section\SectionRepositoryInterface;

class SectionRepositoryContext implements Context, SnippetAcceptingContext
{
    const SECTION_PATH_PATTERN = 'publication/%s/sections';
    
    /**
     * @var Mockery
     */
    private $apiHttpClient;

    /**
     * @var SectionRepositoryInterface
     */
    private $sectionRepository;

    /**
     * @var array
     */
    private $sections;

    /**
     * @var array
     */
    private $sectionsFromApi;

    public function __construct()
    {
        $this->apiHttpClient = Mockery::mock(ApiHttpClientInterface::class);
    }

    /**
     * @Given I create section repository
     */
    public function iCreateSectionRepository()
    {
        $this->sectionRepository = new SectionRepository($this->apiHttpClient);
    }

    /**
     * @Given there are sections for :publicationId publication in API:
     *
     * @param string $publicationId
     * @param PyStringNode $sectionsFromApi
     */
    public function thereAreSectionsForPublicationInAPI($publicationId, PyStringNode $sectionsFromApi)
    {
        $sectionsFromApiWithPublication = str_replace('PUBLICATION_ID', $publicationId, $sectionsFromApi->getRaw());

        $sectionsApiResponse = json_decode($sectionsFromApiWithPublication, true);

        $this->sectionsFromApi[$publicationId] = $sectionsApiResponse['sections'];

        $path = sprintf(self::SECTION_PATH_PATTERN, $publicationId);

        $this->apiHttpClient
            ->shouldReceive('get')
            ->with(Mockery::on(function (ApiHttpPathAndQuery $apiHttpPathAndQuery) use ($path) {
                return $apiHttpPathAndQuery == ApiHttpPathAndQuery::createForPath($path);
            }))
            ->andReturn($sectionsFromApiWithPublication);
    }

    /**
     * @When I ask for sections list for :publicationId publication using section repository
     *
     * @param string $publicationId
     */
    public function iAskForSectionsListForPublicationUsingSectionRepository($publicationId)
    {
        $findParameters = FindAllParameters::createForPublicationId($publicationId);

        $this->sections = $this->sectionRepository->findAll($findParameters)->getSections();
    }

    /**
     * @Then I should get sections list for :publicationId publication with content from API
     *
     * @param $publicationId
     *
     * @throws PhpUnitExpectationFailedException
     */
    public function iShouldGetSectionsListForPublicationWithContentFromApi($publicationId)
    {
        PhpUnit::assertEquals($this->sectionsFromApi[$publicationId], $this->sections);
    }
}
