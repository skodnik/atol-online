<?php

declare(strict_types=1);

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Vlsv\AtolOnline\Entity\PayingAgent;
use Vlsv\AtolOnline\Exception\ApiExceptionIncorrectPhoneNumber;
use Vlsv\AtolOnline\Exception\ApiExceptionWrongStringLength;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class PayingAgentSerializationTest extends TestCase
{
    /**
     * @group feature
     * @throws ApiExceptionIncorrectPhoneNumber
     * @throws ApiExceptionWrongStringLength
     */
    public function testPayingAgentSerialization()
    {
        $serializer = $this->getAtolApiClient()->getSerializer();

        $payingAgent = (new PayingAgent())
            ->setOperation('тестовая операция')
            ->setPhones([getenv('ATOL_PHONE')]);

        self::assertEquals('тестовая операция', $payingAgent->getOperation());

        $jsonExpected = '{"operation":"тестовая операция","phones":["' . getenv('ATOL_PHONE') . '"]}';

        $json = $serializer->serialize($payingAgent, JsonEncoder::FORMAT);
        self::assertJson($json);

        self::assertEquals($jsonExpected, $json);
    }

    /**
     * @group feature
     */
    public function testPayingAgentSerializationExceptionLength()
    {
        try {
            $payingAgent = (new PayingAgent())
                ->setOperation('тестовая операция тестовая операция тестовая операция')
                ->setPhones([getenv('ATOL_PHONE')]);

            self::fail();
        } catch (ApiExceptionWrongStringLength $exception) {
            self::assertInstanceOf(ApiExceptionWrongStringLength::class, $exception);
        } catch (ApiExceptionIncorrectPhoneNumber $exception) {
            self::fail();
        }
    }

    /**
     * @group feature
     */
    public function testPayingAgentSerializationExceptionPhone()
    {
        try {
            $payingAgent = (new PayingAgent())
                ->setOperation('тестовая операция')
                ->setPhones(['1234']);

            self::fail();
        } catch (ApiExceptionIncorrectPhoneNumber $exception) {
            self::assertInstanceOf(ApiExceptionIncorrectPhoneNumber::class, $exception);
        } catch (ApiExceptionWrongStringLength $exception) {
            self::fail();
        }
    }
}
