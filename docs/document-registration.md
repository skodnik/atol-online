# Регистрация документа

Для регистрации документа в ККТ необходимо отправить POST запрос.

Возможные типы операции:

- **sell**: чек «Приход»;
- **sell_refund**: чек «Возврат прихода»;
- **sell_correction**: чек «Коррекция прихода»;
- **buy**: чек «Расход»;
- **buy_refund**: чек «Возврат расхода»;
- **buy_correction**: чек «Коррекция расхода».

## Формирование объекта запроса

```php
$vat = (new \Vlsv\AtolOnline\Entity\Vat())
    ->setType(\Vlsv\AtolOnline\Entity\Enum\VatType::VAT20); // НДС чека по ставке 20%, Типы VatType.php

$item = (new \Vlsv\AtolOnline\Entity\Item())
    ->setName('Колбаса Клинский Брауншвейгская с/к в/с')
    ->setSum('1000')
    ->setPaymentMethod(\Vlsv\AtolOnline\Entity\Enum\PaymentMethod::ADVANCE)
    ...
    ->setVat($vat);

$payment = (new \Vlsv\AtolOnline\Entity\Payment())
    ->setType(1) // 1 - Безналичный, типы платежей см. PaymentType.php
    ->setSum(300);

$receipt = (new \Vlsv\AtolOnline\Entity\Receipt())
    ->setClient($client)
    ->setClient($client)
    ->setCompany($company)
    ->setItems($items)
    ->setPayments([$payment]);

$request = new \Vlsv\AtolOnline\Entity\Request();

$service = (new \Vlsv\AtolOnline\Entity\Service())
            ->setCallbackUrl('https://callback.mysite.com');

$client = new \Vlsv\AtolOnline\Entity\Client();
$company = new \Vlsv\AtolOnline\Entity\Company();

```

## Чек «Приход»

```php
$response = $atolApiClient->sell($request);
```

## Обработка ответа

Проверка наличия ошибки в ответе.

```php
$response->getError();
```

Идентификатор документа в Атол.

```php
$response->getUuid();
```

Статус регистрации документа.

```php
$response->getStatus()->value;
```

Обработка ошибки.

```php
$serviceError = $error->getServiceError();

// Текст ошибки.
$serviceError->getError();

// Описание способа исправления ошибки.
$serviceError->getTroubleshooting()

// Описание ошибки.
$serviceError->getDescription()
```
