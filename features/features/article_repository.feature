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
                    "href": "http://endpoint/content/v3/changelog/PUBLICATION_ID/search"
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

    Scenario: Fetching articles changelog for publication with time range and limit
        Given there is articles changelog for "sa" publication with time range since "2016-01-01" until "2016-02-01" and "2" limit in API:
        """
        {
            "_links": {
                "self": {
                    "href": "http://endpoint/content/v3/changelog/PUBLICATION_ID/search"
                },
                "next": {
                    "href": "http://endpoint/content/v3/changelog/PUBLICATION_ID/search"
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
        When I ask for articles changelog for "sa" publication with time range from "2016-01-01" to "2016-02-01" and "2" limit using article repository
        Then I should get articles changelog for "sa" publication with content from API

    Scenario: Fetching articles from section
        Given there are articles for "sa" publication for section "bolig":
        """
        {
            "total": 287,
            "count": 1,
            "teasers": [
                {
                    "image": {
                        "links": [
                            {
                                "rel": "presentationUrl",
                                "href": "http://vertical.snd.no/incoming/article788835.ece/BINARY/original/tb45c502.jpg?updated=250720161037"
                            }
                        ],
                        "content": {
                            "subtype": "",
                            "width": 4982,
                            "text": "NY LANDSLAGSSJEF: Sam Allardyce møter pressen som England-trener for første gang.",
                            "byline": "Action Images via Reuters / Andrew Couldridge Livepic/NTB scanpix",
                            "height": 3257
                        }
                    },
                    "meta": {
                        "sa.paywall": "open",
                        "score": 1469444360000,
                        "schemaVersion": 4,
                        "origin": "sa@common",
                        "lifetime": 1,
                        "sa.presentation": "news",
                        "hotness": 1
                    },
                    "promotionContent": {},
                    "dates": {
                        "created": "2016-07-25T10:28:00Z",
                        "published": "2016-07-25T10:40:05Z",
                        "updated": "2016-07-25T10:59:20Z"
                    },
                    "leadText": "Englands nye landslagstrener ble presentert mandag.",
                    "section": "bolig",
                    "source": {
                        "system": "escenic",
                        "publication": "sa",
                        "id": "788824",
                        "escenicId": 788824
                    },
                    "id": 612,
                    "title": "Allardyce taus om Rooneys fremtid"
                }
            ]
        }
        """
        When I ask for articles for "sa" publication for section "bolig"
        Then I should get articles for "sa" publication with content from API

    Scenario: Fetching desked articles
        Given there are articles for "bt" publication for desked section "forsiden":
        """
        {
            "total": 88,
            "count": 1,
            "teasers": [
                {
                    "id": 324087,
                    "title": "Fem personer må hjelpes ned fra Trolltunga",
                    "frontPageTitle": "Fem personer må hjelpes ned fra Trolltunga",
                    "mobileFrontPageTitle": "Fem personer må hjelpes ned fra Trolltunga",
                    "frontPageLeadText": "– De er våte og kalde, sier politiet.",
                    "mobileFrontPageLeadText": "– De er våte og kalde, sier politiet.",
                    "xhtmlFrontPageLeadText": "<div xmlns=\"http://www.w3.org/1999/xhtml\"><p>– De er våte og kalde, sier politiet.</p></div>",
                    "leadText": {
                        "text": "– De er våte og kalde, sier politiet."
                    },
                    "headerTitle": "Lokalt",
                    "elementWidth": 100,
                    "elementPosition": 1,
                    "skin": "theme-Anbefalt",
                    "moreToFollow": "",
                    "showFpTip": false,
                    "hideOnSmallScreen": false,
                    "source": {
                        "id": "6geg8",
                        "publication": "bt",
                        "system": "bench"
                    },
                    "type": "v3",
                    "links": [
                        {
                          "rel": "presentationUrl",
                          "href": "http://www.bt.no/nyheter/lokalt/To-kvinner-ma-hjelpes-ned-fra-Trolltunga-324087b.html"
                        },
                        {
                          "rel": "capiUrl",
                          "href": "http://api.schibsted.tech/content/v3/publication/bt/articles/324087"
                        },
                        {
                          "rel": "shareUrl",
                          "href": "http://www.bt.no/article/bt-324087b.html"
                        }
                    ],
                    "dates": {
                        "created": "2016-09-30T03:23:18Z",
                        "published": "2016-09-30T06:56:57Z",
                        "updated": "2016-09-30T07:40:33Z"
                    },
                    "section": {
                        "title": "nyheter:lokalt"
                    },
                    "paywall": {
                        "code": "301376",
                        "state": "open",
                        "type": "subscription"
                    }
                }
            ]
        }
        """
        When I ask for articles for "bt" publication for desked section "forsiden"
        Then I should get articles for "bt" publication with content from API
