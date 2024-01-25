<?php

declare(strict_types=1);

namespace Unit;

use Vlsv\AtolOnline\Api\ServiceError;
use Vlsv\AtolOnline\Api\StatusErrorConstants;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class ServiceErrorTest extends TestCase
{
    public function errorCodesProvider(): array
    {
        return [
            [0, 'unknown', StatusErrorConstants::UNDEFINED_ERROR],
            [1, 'system', StatusErrorConstants::INCOMING_CHEQUE_PROCESSING_FAILED],
            [10, 'system', StatusErrorConstants::MISSING_TOKEN],
            [11, 'system', StatusErrorConstants::EXPIRED_TOKEN],
            [12, 'system', StatusErrorConstants::WRONG_LOGIN_OR_PASSWORD],
            [13, 'system', StatusErrorConstants::VALIDATION_EXCEPTION],
            [14, 'system', StatusErrorConstants::USER_BLOCKED],
            [20, 'system', StatusErrorConstants::GROUP_CODE_AND_TOKEN_DONT_MATCH],
            [21, 'system', StatusErrorConstants::NOT_SUPPORTED_GROUP_CODE_FOR_PROTOCOL],
            [30, 'system', StatusErrorConstants::MISSING_UUID],
            [31, 'system', StatusErrorConstants::INCOMING_OPERATION_NOT_SUPPORTED],
            [32, 'system', StatusErrorConstants::INCOMING_VALIDATION_EXCEPTION],
            [33, 'system', StatusErrorConstants::INCOMING_EXTERNAL_ID_ALREADY_EXISTS],
            [34, 'system', StatusErrorConstants::STATE_CHECK_NOT_FOUND],
            [40, 'system', StatusErrorConstants::BAD_REQUEST],
            [41, 'system', StatusErrorConstants::UNSUPPORTED_MEDIA_TYPE],
            [50, 'system', StatusErrorConstants::ERROR_SERVER_CONFIGURATION],
            [1, 'timeout', StatusErrorConstants::TIMEOUT_FAIL],
        ];
    }

    /**
     * @group        unit
     * @dataProvider errorCodesProvider
     */
    public function testGetErrorByCode(int $errorCode, string $type, array $expectedError)
    {
        $result = ServiceError::getErrorByCodeAndType($errorCode, $type);

        self::assertEquals($expectedError['httpsCode'], $result->getHttpsCode());
        self::assertEquals($expectedError['code'], $result->getCode());
        self::assertEquals($expectedError['error'], $result->getError());
        self::assertEquals($expectedError['description'], $result->getDescription());
        self::assertEquals($expectedError['troubleshooting'], $result->getTroubleshooting());
        self::assertEquals($expectedError['type'], $result->getType());
        self::assertEquals($expectedError['status'], $result->getStatus());
    }
}
