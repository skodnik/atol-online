# Debug

## http-клиент PhpStorm

В директории misc фалы запросов http-клиента PhpStorm.

- Получение токена – [getToken.http](../misc/http/getToken.http)
- Выполнение операции – [operation.http](../misc/http/operation.http)
- Проверка статуса – [report.http](../misc/http/report.http)

json ответы сохраняются в директории [http](../data/tmp/jsons/)

## Интеграционные тесты

По умолчанию http-клиент библиотеки инициализируется с [DebugObserver](../src/Observer/DebugObserver.php).

Файлы запросов, как и json данные сохраняются в [data/tmp/debug](../data/tmp/debug/).
