# CAPI SDK USAGE

## How to create CAPI Client?

First, you have to create Http Client:

```
$httpClient = new HttpClient(
    new HttpClientConfiguration('endpoint', 'apiKey', 'apiSecret'),
    new Client()
);
```

## Articles

### Fetching one by id for publication id

```
$articleRepository = new ArticleRepository($httpClient);

try {
    $findParameters = FindParameters::createForPublicationIdAndArticleId('sa', 1);
    $article = $articleRepository->find($findParameters);
} catch (CouldNotFetchArticleRepositoryException $exception) {
}
```

### Fetching many by ids for publication id

```
$articleRepository = new ArticleRepository($httpClient);

try {
    $findParameters = FindParameters::createForPublicationIdAndArticleIds('sa', [1,2,3]);
    $articles = $articleRepository->findByIds($findParameters);
} catch (CouldNotFetchArticleRepositoryException $exception) {
}
```

## Sections

### Fetching all sections for publication id

```
$sectionRepository = new SectionRepository($httpClient);

try {
    $findParameters = FindParameters::createForPublicationId('sa');
    $sections = $sectionRepository->findAll($findParameters);
} catch (CouldNotFetchSectionRepositoryException $exception) {
}
```
