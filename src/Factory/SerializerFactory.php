<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Factory;

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class SerializerFactory
{
    public static function getSerializer(string $dateTimeFormat = 'd.m.Y H:i:s'): Serializer
    {
        $normalizers = [
            new BackedEnumNormalizer(),
            new ArrayDenormalizer(),
            new DateTimeNormalizer([
                DateTimeNormalizer::FORMAT_KEY => $dateTimeFormat,
            ]),
            new PropertyNormalizer(
                propertyTypeExtractor: new PropertyInfoExtractor(
                    typeExtractors: [
                        new PhpDocExtractor(),
                        new ReflectionExtractor(),
                    ]
                ),
                defaultContext: [
                    'skip_null_values' => true,
                ],
            ),
        ];
        $encoders = [new JsonEncoder(defaultContext: ['json_encode_options' => JSON_UNESCAPED_UNICODE])];

        return new Serializer($normalizers, $encoders);
    }
}
