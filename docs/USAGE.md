# CAPI SDK USAGE

## How to create CAPI Client?

First, you have to create API Client:

```
$client = new ApiClient(new ApiClientConfiguration($endpoint, $apiKey, $apiSecret));
```

## Article

You can easily fetch article by parameters like shown below:

```
try {
    $article = $client->getArticleRepositoryForPublication($publicationId)->find($articleId);
} catch (CouldNotFetchArticleException $exception) {
}
```
