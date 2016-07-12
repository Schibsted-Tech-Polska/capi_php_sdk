Feature: API Client usage
    In order to communicate with Snt CAPI easily
    As a SDK User
    I want to use API Client for fetching articles

    Background:
        Given I create API Client with "host" endpoint and "abc" api key and "secret" api secret

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

    Scenario: Fetching many articles using API Client
        Given there are articles for "sa" publication:
        """
        {
            "articles" :
            [
                {
                    "id": 51879,
                    "state": "published",
                    "title": "«Barnebruder», nødens salgsvare | Merete Munch"
                },
                {
                    "id": 51881,
                    "state": "published",
                    "title": "Kapteinen Vålerengas beste"
                }
            ]
        }
        """
        When I ask for articles for "sa" publication using API Client:
            | article_id |
            | 51879      |
            | 51881      |
        Then I should get "51881" article for "sa" publication with content from API
        And I should get "51879" article for "sa" publication with content from API
