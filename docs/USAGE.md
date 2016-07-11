# CAPI SDK USAGE

## How to create CAPI Client?

First, you have to create API Client:

```
$client = new ApiClient(new ApiClientConfiguration($endpoint, $apiKey, $apiSecret));
```

## Article

### Fetching one by id

You can easily fetch article by parameters like shown below:

```
try {
    $article = $client->getArticleRepositoryForPublication('sa')->find(1);
} catch (CouldNotFetchArticleException $exception) {
}
```

### Fetching many by ids
You can easily fetch article by parameters like shown below:

```
try {
    $articles = $client->getArticleRepositoryForPublication('sa')->findByIds([1,2,3]);
} catch (CouldNotFetchArticleException $exception) {
}
```
