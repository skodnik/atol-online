<?php

declare(strict_types=1);

namespace Feature\ItemsSerialization;

use Vlsv\AtolOnline\Api\ServiceError;
use Vlsv\AtolOnline\Entity\Error;
use Vlsv\AtolOnline\Tests\Factory\ErrorFactory;
use Vlsv\AtolOnline\Tests\TestCase;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class ErrorSerializationTest extends TestCase
{
    public function errorDataProvider(): array
    {
        $factory = new ErrorFactory();

        return [
            [...$factory->fromJson('error-fiscalization-11.json'), ServiceError::EXPIRED_TOKEN],
            [...$factory->fromJson('error-fiscalization-34.json'), ServiceError::STATE_CHECK_NOT_FOUND],
        ];
    }

    /**
     * @group        feature
     * @dataProvider errorDataProvider
     */
    public function testErrorSerialization($error, $object, $serviceErrorExpected)
    {
        self::assertInstanceOf(Error::class, $error);

        self::assertEquals($object->code, $error->getCode());
        self::assertEquals($object->type, $error->getType());
        self::assertEquals($object->text, $error->getText());
        self::assertEquals($object->error_id, $error->getErrorId());

        $serviceError = ServiceError::getErrorByCodeAndType($error->getCode(), $error->getType());

        self::assertEquals($serviceErrorExpected['error'], $serviceError->getError());
    }
}
