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
    $article = $client->getArticleRepository()->findForPublicationId('sa', 1);
} catch (CouldNotFetchArticleRepositoryException $exception) {
}
```

### Fetching many by ids
You can easily fetch article by parameters like shown below:

```
try {
    $articles = $client->getArticleRepositoryForPublication()->findByIdsForPublicationId('sa', [1,2,3]);
} catch (CouldNotFetchArticleRepositoryException $exception) {
}
```

### Custom article repository decorator

If you want to modify behaviour of article repository you can easily create custom one by extending ```AbstractArticleRepositoryDecorator```:
```
class EntityArticleRepository extends AbstractArticleRepositoryDecorator
{
    /**
     * {@inheritdoc}
     */
    public function findForPublicationId($publicationId, $articleId)
    {
        // you have access to object which is decorated
        return new Entity($this->articleRepository->findForPublicationId($publicationId, $articleId));
    }

    /**
     * {@inheritdoc}
     */
    public function findByIdsForPublicationId($publicationId, array $articleIds)
    {
        // same as above...
    }
}

$apiClient->setArticleRepository(new EntityArticleRepository($apiClient->getArticleRepository()));

```
