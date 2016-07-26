# CAPI SDK USAGE

## Installation

Requires PHP 5.5 or higher.

You can install it using composer:

`composer require schibsted-tech-polska/capi_php_sdk`

Keep in mind that this package needs two virtual packages implementations.

## How to create CAPI Client?


First, you have to create APi Http Client:

```
$apiHttpClient = new ApiHttpClient(
    new HttpClient(),
    new ApiHttpClientConfiguration('endpoint', 'apiKey', 'apiSecret'),
    new RequestFactory()
);
```
First argument requires `HttpClient` interface and it can be delivered by `php-http/client-implementation` virtual package
Third argument requires `RequestFactory` interface and it can be delivered by `php-http/message-factory-implementation` virtual package

## Articles

### Fetching one by id for publication id

```
$articleRepository = new ArticleRepository($apiHttpClient);

try {
    $findParameters = FindParameters::createForPublicationIdAndArticleId(PublicationId::AP, 1);
    $article = $articleRepository->find($findParameters);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```

### Fetching many by ids for publication id

```
$articleRepository = new ArticleRepository($apiHttpClient);

try {
    $findParameters = FindByIdsParameters::createForPublicationIdAndArticleIds(PublicationId::SA, [1,2,3]);
    $articles = $articleRepository->findByIds($findParameters);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```

### Fetching articles changelog for publication id

```
$articleRepository = new ArticleRepository($apiHttpClient);

try {
    $findParameters = FindByChangelogParameters::createForPublicationId(PublicationId::SA);
    $articles = $articleRepository->findByChangelog($findParameters);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```

### Fetching articles changelog for publication id with time range and limit parameters

```
$articleRepository = new ArticleRepository($apiHttpClient);

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

For `$findParameters` you can use also: `createForPublicationIdWithTimeRangeAndLimitAndOffset`, `createForPublicationId` and `createForPublicationIdFromArray` methods.

### Fetching articles from sections

```
$articleRepository = new ArticleRepository($apiHttpClient);

try {
    $findParameters = FindBySectionParameters::createForPublicationIdAndSections(PublicationId::SA, ['lokalt']);
    $articles = $articleRepository->findBySections($findParameters);

    print_r($articles);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```

## Sections

### Fetching all sections for publication id

```
$sectionRepository = new SectionRepository($apiHttpClient);

try {
    $findParameters = FindAllParameters::createForPublicationId(PublicationId::BT);
    $sections = $sectionRepository->findAll($findParameters);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```
