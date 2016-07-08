# CAPI SDK USAGE

## How to create CAPI Client?

First, you have to create API Client:

```
$client = new Client($endpoint, $apiKey, $apiSecret);
```

## Article

You can easily fetch article by parameters like shown below:

```
$article = $client->getArticleRepository('sa')->find('1234');
```
