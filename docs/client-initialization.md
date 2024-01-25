# Инициализация клиента

Для начала работы с библиотекой необходимо создать объект аккаунт:

```php
$account = new \Vlsv\AtolOnline\AtolAccount(
    host: 'atol_test_host',
    serviceVersion: 'atol_service_version',
    company: 'atol_company',
    inn: 'atol_inn',
    groupCode: 'atol_group_code',
    login: 'atol_login',
    password: 'atol_password',
    email: 'atol_email',
    sno: 'atol_sno',
    debug: false,
);
```

Затем создать объект клиент:

```php
$atolApiClient = new \Vlsv\AtolOnline\AtolApiClient(
    atolAccount: $account,
);
```
