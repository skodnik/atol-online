# Кеширование

Библиотека поддерживает кеширование совместимыми с PSR-16 клиентами. В качестве примера и для тестов идет простой класс
кеширования основанный на файлах.

```php
$atolApiClient->setCache(new \Vlsv\AtolOnline\SimpleFileCachePsr16());
```

В конструктор можно передать путь к директории временных файлов проекта в котором применяется библиотека, однако,
целесообразнее применять иной способ кеширования, например,
[symfony/cache](https://packagist.org/packages/symfony/cache).

## Пример ApiClientFactory для Laravel

```php
public static function create(AtolAccount $atolAccount, bool $inMemcached = true): AtolApiClient
{
    $cache = $inMemcached
        ? new Repository(new MemcachedStore(Cache::getMemcached())) // Кеширование с помощью класса Memcached
        : new SimpleFileCachePsr16(storage_path('app') . '/tmp/atol'); // Кеширование с применением класса из библиотеки

    return (new AtolApiClient($atolAccount))
        ->setCache($cache);
}
```
