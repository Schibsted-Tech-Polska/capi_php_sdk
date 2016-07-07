<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Snt\Capi\Client;
use PHPUnit_Framework_TestCase as PhpUnit;

class ClientContext implements Context, SnippetAcceptingContext
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @When I create API Client with :endpoint endpoint and :apiKey api key and :apiSecret api secret
     *
     * @param string $endpoint
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function iCreateApiClientWithEndpointAndApiKeyAndApiSecret($endpoint, $apiKey, $apiSecret)
    {
        $this->client = new Client($endpoint, $apiKey, $apiSecret);
    }

    /**
     * @Then I should get API Client with :endpoint endpoint and :apiKey api key and :apiSecret api secret
     *
     * @param string $endpoint
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function iShouldGetApiClientWithEndpointAndApiKeyAndApiSecret($endpoint, $apiKey, $apiSecret)
    {
        PhpUnit::assertEquals($endpoint, $this->client->getEndpoint());
        PhpUnit::assertEquals($apiKey, $this->client->getApiKey());
        PhpUnit::assertEquals($apiSecret, $this->client->getApiSecret());
    }
}
