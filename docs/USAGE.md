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
    $findParameters = FindParameters::createForPublicationIdAndArticleId(PublicationId::AP, 1);
    $article = $articleRepository->find($findParameters);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```

### Fetching many by ids for publication id

```
$articleRepository = new ArticleRepository($httpClient);

try {
    $findParameters = FindByIdsParameters::createForPublicationIdAndArticleIds(PublicationId::SA, [1,2,3]);
    $articles = $articleRepository->findByIds($findParameters);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```

### Fetching articles changelog for publication id

```
$articleRepository = new ArticleRepository($httpClient);

try {
    $findParameters = FindByChangelogParameters::createForPublicationId(PublicationId::SA);
    $articles = $articleRepository->findByChangelog($findParameters);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```

### Fetching articles changelog for publication id with time range and limit parameters

```
$articleRepository = new ArticleRepository($httpClient);

try {
    $limit = 10;
    $timeRange = new TimeRangeParameter(new DateTime('2016-06-01'), new DateTime('2016-07-01'));

    $findParameters = FindByChangelogParameters::createForPublicationIdWithTimeRangeAndLimit(
        PublicationId::SA,
        $timeRange,
        $limit
    );
    
    $articles = $articleRepository->findByChangelog($findParameters);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```

## Sections

### Fetching all sections for publication id

```
$sectionRepository = new SectionRepository($httpClient);

try {
    $findParameters = FindAllParameters::createForPublicationId(PublicationId::BT);
    $sections = $sectionRepository->findAll($findParameters);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```
