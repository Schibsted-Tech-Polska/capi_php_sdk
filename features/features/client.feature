Feature: API Client usage
    In order to communicate with Snt CAPI easily
    As a SDK User
    I want to use API Client for fetching data

    Background:
        Given I create API Client with "host" endpoint and "abc" api key and "secret" api secret

    Scenario: API Client creation
        Then I should get API Client with "host" endpoint and "abc" api key and "secret" api secret

    Scenario: Fetching one article using API Client
        Given there is "51870" article for "sa" publication:
        """
        {
            "id": 51870,
            "state": "published",
            "title": "Teknisk test - 7.juli."
        }
        """
        When I ask for "51870" article for "sa" publication using API Client
        Then I should get "51870" article for "sa" publication with content from API
