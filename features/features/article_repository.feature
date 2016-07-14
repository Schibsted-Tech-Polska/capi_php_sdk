Feature: Article repository usage
    In order to communicate with Snt CAPI easily
    As a SDK User
    I want to use article repository for fetching articles

    Background:
        Given I create article repository

    Scenario: Fetching one article for publication using article repository
        Given there is "51870" article for "sa" publication in API:
        """
        {
            "id": 51870,
            "state": "published",
            "title": "Teknisk test - 7.juli."
        }
        """
        When I ask for "51870" article for "sa" publication using article repository
        Then I should get "51870" article for "sa" publication with content from API

    Scenario: Fetching many articles for publication using API Client
        Given there are articles for "sa" publication in API:
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
        When I ask for articles for "sa" publication using article repository:
            | article_id |
            | 51879      |
            | 51881      |
        Then I should get "51881" article for "sa" publication with content from API
        And I should get "51879" article for "sa" publication with content from API

        Scenario: Fetching articles changelog for publication using article repository
            Given there is articles changelog for "sa" publication in API:
            """
            {
                "_links": {
                    "self": {
                        "href": "http://endpoint/content/v3/changelog/PUBLICATION_ID/search"
                    },
                    "next": {
                        "href": "http://api.schibsted.tech/content/v3/changelog/PUBLICATION_ID/search"
                    }
                },
                "articles": [
                    {
                        "id": 17683,
                        "publication": "PUBLICATION_ID",
                        "presentationurl": "http://example.com/live",
                        "type": "updated",
                        "eventdate": "2016-07-14 12:49:15.289"
                    }
                ],
                "totalArticles": 1
            }
            """
            When I ask for articles changelog for "sa" publication using article repository
            Then I should get articles changelog for "sa" publication with content from API
