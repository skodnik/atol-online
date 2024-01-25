<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Tests\Factory;

use DateTimeImmutable;
use Vlsv\AtolOnline\Entity\Receipt;
use Vlsv\AtolOnline\Entity\Request\Request;
use Vlsv\AtolOnline\Entity\Service;
use Vlsv\AtolOnline\Exception\ApiExceptionWrongArrayLength;
use Vlsv\AtolOnline\Exception\ApiExceptionWrongStringLength;
use Vlsv\AtolOnline\Exception\ApiExceptionWrongUrl;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class RequestSellFactory extends TestCase
{
    /**
     * @throws ApiExceptionWrongArrayLength
     * @throws ApiExceptionWrongUrl
     * @throws ApiExceptionWrongStringLength
     */
    public function get(): Request
    {
        ['entity' => $vat] = (new VatFactory())->fromJson('vat.json');
        ['entity' => $item] = (new ItemFactory())->fromJson('item.json');
        $item->setVat($vat);
        $items = [$item];

        ['entity' => $payment] = (new PaymentFactory())->fromJson('payment.json');

        $service = (new Service())
            ->setCallbackUrl(getenv('ATOL_CALLBACK_URL'));

        ['entity' => $client] = (new ClientFactory())->fromEnv();
        ['entity' => $company] = (new CompanyFactory())->fromEnv();

        $receipt = (new Receipt())
            ->setClient($client)
            ->setCompany($company)
            ->setItems($items)
            ->setPayments([$payment])
            ->calculateAndSetVatsAndTotal();

        return (new Request())
            ->setExternalId(getenv('ATOL_GROUP_CODE') . rand(100000, 999999))
            ->setTimestamp(new DateTimeImmutable())
            ->setService($service)
            ->setReceipt($receipt);
    }
}
