Feature: Section repository usage
    In order to communicate with Snt CAPI easily
    As a SDK User
    I want to use section repository for fetching sections

    Scenario: Fetching all sections for publication
        Given I create section repository
        And there are sections for "sa" publication in API:
        """
        {
            "_links": {
                "self": {
                   "href": "http://endpoint/v3/publication/PUBLICATION_ID/sections"
                }
            },
            "sections":[
                {
                    "title": "Sport",
                    "label": "Sport",
                    "_links": {
                        "self": {
                            "href": "http://endpoint/v3/publication/PUBLICATION_ID/sections/sport"
                        },
                        "properties": {
                            "href": "http://endpoint/v3/publication/PUBLICATION_ID/sections/sport/properties"
                        },
                        "latest": {
                            "href": "http://endpoint/v3/publication/PUBLICATION_ID/sections/sport/latest"
                        },
                        "presentation": {
                            "href": "http://www.example.com/sport"
                        }
                    }
                },
                {
                    "title": "kultur",
                    "label": "kultur",
                    "_links": {
                        "self": {
                            "href": "http://endpoint/v3/publication/PUBLICATION_ID/sections/kultur"
                        },
                        "properties": {
                            "href": "http://endpoint/v3/publication/PUBLICATION_ID/sections/kultur/properties"
                        },
                        "latest": {
                            "href": "http://endpoint/v3/publication/PUBLICATION_ID/sections/kultur/latest"
                        },
                        "presentation": {
                            "href": "http://www.example.com/kultur"
                        }
                    }
                }
            ]
        }
        """
        When I ask for sections list for "sa" publication using section repository
        Then I should get sections list for "sa" publication with content from API
