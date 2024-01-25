![workflow](https://github.com/skodnik/atol-online/actions/workflows/main.yml/badge.svg)

# Http клиент для работы с API АТОЛ Онлайн. 54–ФЗ.

## Уведомление

Основано на ["Описание протокола"](docs/API_atol_online_v4.pdf) Версия сервиса v4, Версия документа 5.15.

## Установка

```shell
composer require vlsv/atol-online
```

## Использование

1. [Инициализация клиента](docs/client-initialization.md)
2. [Кеширование](docs/caching.md)
3. [Авторизация пользователя](docs/user-authorization.md)
4. [Регистрация документа](docs/document-registration.md)
5. [Получение результата обработки документа](docs/report.md)
6. [Debug](docs/debug.md)

Больше примеров использования в тестах.

## Тесты

```shell
composer tests
```

## Разное

[Ошибки при работе с ККТ](docs/kkt-errors.csv) 

## Лицензия

[GNU General Public License v3](LICENSE)

## Отказ от ответственности

Автор не несет ответственности за какие-либо претензии, убытки или другие обязательства, возникшие или возникающие в
результате использования, распространения или других видов обращения с данным программным обеспечением.
