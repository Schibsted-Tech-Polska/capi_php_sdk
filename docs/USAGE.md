# CAPI SDK USAGE

## How to create CAPI Client?

First, you have to create API Client:

```
$client = new Client(
    new ClientConfiguration($endpoint, $apiKey, $apiSecret)
);
```

## Article

You can easily fetch article by parameters like shown below:

```
$article = $client->getArticleRepository()->find('sa', '1234');
```
