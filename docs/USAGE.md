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
    $findParameters = FindParameters::createForPublicationAndArticleId(self::PUBLICATION_ID, self::ARTICLE_ID);
    $article = $articleRepository->find($findParameters);
} catch (CouldNotFetchArticleRepositoryException $exception) {
}
```

### Fetching many by ids
You can easily fetch article by parameters like shown below:

```
try {
    $findByIdsParameters = FindByIdsParameters::createForPublicationAndArticleIds(self::PUBLICATION_ID, [self::ARTICLE_ID]);
    $articles = $articleRepository->findByIds($findByIdsParameters);
} catch (CouldNotFetchArticleRepositoryException $exception) {
}
```
