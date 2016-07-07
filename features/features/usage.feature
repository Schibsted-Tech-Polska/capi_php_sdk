Feature: API Client usage
    In order to communicate with Snt CAPI easily
    As a SDK User
    I want to use API Client for fetching data

    Scenario: API Client creation
        When I create API Client with "host" endpoint and "abc" api key and "secret" api secret
        Then I should get API Client with "host" endpoint and "abc" api key and "secret" api secret
