# CAPI SDK USAGE

## Installation

Requires PHP 5.6 or higher.

You can install it using composer:

`composer require schibsted-tech-polska/capi_php_sdk`

Keep in mind that this package needs two virtual packages implementations.

## How to create CAPI Client?


First, you have to create API Http Client:

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
    $response = $articleRepository->find($findParameters);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```

### Fetching one editorial article by id for publication id

Editorial article is an article that may have status other than published.

```
$articleRepository = new ArticleRepository($apiHttpClient);

try {
    $findParameters = FindEditorialParameters::createForPublicationIdAndArticleId(PublicationId::AP, 1);
    $response = $articleRepository->findEditorial($findParameters);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```

NOTE: This method requires elevated privileges in CAPI.

### Fetching many by ids for publication id

```
$articleRepository = new ArticleRepository($apiHttpClient);

try {
    $findParameters = FindByIdsParameters::createForPublicationIdAndArticleIds(PublicationId::SA, [1,2,3]);
    $response = $articleRepository->findByIds($findParameters);
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
    
    $response = $articleRepository->findByChangelog($findParameters);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```

For `$findParameters` you can use also: `createForPublicationIdWithTimeRangeAndLimitAndOffset`, `createForPublicationId` and `createForPublicationIdFromArray` methods.

### Fetching articles from sections

```
$articleRepository = new ArticleRepository($apiHttpClient);

try {
    $findParameters = FindBySectionParameters::createForPublicationIdAndSections(PublicationId::SA, ['lokalt']);
    $response = $articleRepository->findBySections($findParameters);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```

## Sections

### Fetching all sections for publication id

```
$sectionRepository = new SectionRepository($apiHttpClient);

try {
    $findParameters = FindAllParameters::createForPublicationId(PublicationId::BT);
    $response = $sectionRepository->findAll($findParameters);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```

## Search

## Fetching articles by query string

```php
$articleRepository = new ArticleRepository($apiHttpClient);

try {
    $findParameters = FindWithQueryParameters::createForPublicationIdAndQuery(PublicationId::BY, 'mablis');
    $articles = $articleRepository->findWithQuery($findParameters);
} catch (CouldNotFetchResourceRepositoryException $exception) {
}
```

## PublicationId

This class contains all publications existing in CAPI. You can also get publication id with perspective using:
```
PublicationId::createWithPerspective($publication, $perspective);
```
