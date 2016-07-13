# CAPI SDK USAGE

## How to create CAPI Client?

First, you have to create Article Repository:

```
$httpClient = new HttpClient(
    new HttpClientConfiguration('endpoint', 'apiKey', 'apiSecret'),
    new Client()
);

$articleRepository = new ArticleRepository($httpClient);
```

## Article

### Fetching one by id

You can easily fetch article by parameters like shown below:

```
try {
    $findParameters = FindParameters::createForPublicationAndArticleId('sa', 1);
    $article = $articleRepository->find($findParameters);
} catch (CouldNotFetchArticleRepositoryException $exception) {
}
```

### Fetching many by ids
You can easily fetch article by parameters like shown below:

```
try {
    $findParameters = FindParameters::createForPublicationAndArticleIds('sa', [1,2,3]);
    $articles = $articleRepository->findByIds($findParameters);
} catch (CouldNotFetchArticleRepositoryException $exception) {
}
```
