<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline\Api;

/**
 * Ошибки сервиса.
 *
 * @see     API_atol_online_v4.pdf (Версия сервиса v4, Версия документа 5.15) стр. 63
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
abstract class StatusErrorConstants
{
    public const UNDEFINED_ERROR = [
        'httpsCode' => 400,
        'code' => 0,
        'error' => 'Undefined',
        'description' => 'Неизвестная ошибка обработки.',
        'troubleshooting' => 'Обратитесь к Администратору с полученным <error_id>.',
        'type' => 'unknown',
        'status' => null,
    ];

    public const INCOMING_CHEQUE_PROCESSING_FAILED = [
        'httpsCode' => 400,
        'code' => 1,
        'error' => 'IncomingChequeProcessingFailed',
        'description' => 'Сервер не смог обработать входной чек.',
        'troubleshooting' => 'Обратитесь к Администратору с полученным <error_id>.',
        'type' => 'system',
        'status' => null,
    ];

    public const MISSING_TOKEN = [
        'httpsCode' => 401,
        'code' => 10,
        'error' => 'MissingToken',
        'description' => 'Не распознан токен запроса',
        'troubleshooting' => 'Передан некорректный <token>. Чек не был зарегистрирован в сервисе. Необходимо повторить запрос с тем же или новым уникальным значением <external_id>, указав корректный <token> через заголовок HTTPS запроса: Token: <token>.',
        'type' => 'system',
        'status' => null,
    ];

    public const EXPIRED_TOKEN = [
        'httpsCode' => 401,
        'code' => 11,
        'error' => 'ExpiredToken',
        'description' => 'Переданный токен не активен',
        'troubleshooting' => 'Срок действия, переданного <token> истёк (срок действия 24 часа). Необходимо запросить новый <token>.',
        'type' => 'system',
        'status' => null,
    ];

    public const WRONG_LOGIN_OR_PASSWORD = [
        'httpsCode' => 401,
        'code' => 12,
        'error' => 'WrongLoginOrPassword',
        'description' => 'Неверный логин или пароль',
        'troubleshooting' => 'Необходимо повторить запрос с корректными данными.',
        'type' => 'system',
        'status' => null,
    ];

    public const VALIDATION_EXCEPTION = [
        'httpsCode' => 400,
        'code' => 13,
        'error' => 'ValidationException',
        'description' => 'Ошибка валидации входящего запроса. Ошибочные поля: {0}.',
        'troubleshooting' => 'Необходимо повторить запрос с корректными данными.',
        'type' => 'system',
        'status' => null,
    ];

    public const USER_BLOCKED = [
        'httpsCode' => 403,
        'code' => 14,
        'error' => 'UserBlocked',
        'description' => 'Пользователь заблокирован',
        'troubleshooting' => 'Необходимо обратиться в службу технической поддержки АТОЛ Онлайн для разблокирования пользователя.',
        'type' => 'system',
        'status' => null,
    ];

    public const GROUP_CODE_AND_TOKEN_DONT_MATCH = [
        'httpsCode' => 401,
        'code' => 20,
        'error' => 'GroupCodeAndTokenDontMatch',
        'description' => 'Код группы, указанный в запросе, не соответствует токену.',
        'troubleshooting' => 'Передан некорректный <token> или <group_code>. Документ не был зарегистрирован в сервисе. Необходимо повторить запрос с тем же или новым уникальным значением <external_id>, указав корректный <group_code>, соответствующий передаваемому <token>.',
        'type' => 'system',
        'status' => null,
    ];

    public const NOT_SUPPORTED_GROUP_CODE_FOR_PROTOCOL = [
        'httpsCode' => 401,
        'code' => 21,
        'error' => 'NotSupportedGroupCodeForProtocol',
        'description' => 'Код группы не поддерживает данную версию протокола.',
        'troubleshooting' => 'Кассы, относящиеся к группе, не поддерживают ФФД 1.05 и версию сервиса v4. Необходимо отправить запрос на версию сервиса v5 с поддержкой ФФД 1.2.',
        'type' => 'system',
        'status' => null,
    ];

    public const MISSING_UUID = [
        'httpsCode' => 400,
        'code' => 30,
        'error' => 'MissingUuid',
        'description' => 'Передан некорректный UUID : "{0}". Необходимо повторить запрос с корректными данными',
        'troubleshooting' => 'Передан некорректный UUID или указанный UUID не найден. Необходимо повторить запрос с корректным UUID.',
        'type' => 'system',
        'status' => 'fail',
    ];

    public const INCOMING_OPERATION_NOT_SUPPORTED = [
        'httpsCode' => 400,
        'code' => 31,
        'error' => 'IncomingOperationNotSupported',
        'description' => 'Операция "{0}" не поддерживается.',
        'troubleshooting' => 'Передано некорректное значение <operation>. Документ не был зарегистрирован в сервисе. Необходимо повторить запрос с тем же или новым уникальным значением <external_id>, указав корректное значение <operation>.',
        'type' => 'system',
        'status' => null,
    ];

    public const INCOMING_VALIDATION_EXCEPTION = [
        'httpsCode' => 400,
        'code' => 32,
        'error' => 'IncomingValidationException',
        'description' => 'Ошибка валидации входного чека. Ошибочные поля : {1}',
        'troubleshooting' => 'Ошибка валидации JSON. Документ не был зарегистрирован в сервисе. Необходимо повторить запрос с тем же или новым уникальным значением <external_id>, указав корректные данные.',
        'type' => 'system',
        'status' => 'fail',
    ];

    public const INCOMING_EXTERNAL_ID_ALREADY_EXISTS = [
        'httpsCode' => 400,
        'code' => 33,
        'error' => 'IncomingExternalIdAlreadyExists',
        'description' => 'В системе существует чек с external_id : {0} и group_code: {1}',
        'troubleshooting' => 'Документ с переданными значениями <external_id> и <group_code> уже существует в базе.',
        'type' => 'system',
        'status' => 'wait',
    ];

    public const STATE_CHECK_NOT_FOUND = [
        'httpsCode' => 200,
        'code' => 34,
        'error' => 'StateCheckNotFound',
        'description' => 'Состояние чека не найдено. Попробуйте позднее.',
        'troubleshooting' => 'Документ еще не обработан. Необходимо повторить запрос на получение результата обработки чека позднее. Повторно отправлять чек на регистрацию не нужно.',
        'type' => 'system',
        'status' => 'wait',
    ];

    public const BAD_REQUEST = [
        'httpsCode' => 400,
        'code' => 40,
        'error' => 'BadRequest',
        'description' => 'Некорректный запрос.',
        'troubleshooting' => 'Проверьте правильность отправляемого HTTPS запроса, HTTPS заголовка и тела HTTPS сообщения. Необходимо повторить запрос с корректными данными.',
        'type' => 'system',
        'status' => null,
    ];

    public const UNSUPPORTED_MEDIA_TYPE = [
        'httpsCode' => 415,
        'code' => 41,
        'error' => 'UnsupportedMediaType',
        'description' => 'Некорректный Content-Type: {0}.',
        'troubleshooting' => 'Передан некорректный Content-type. Документ не был зарегистрирован в сервисе. Необходимо повторить запрос с тем же или новым уникальным значением <external_id>, указав Content-type: application/json; charset=utf-8.',
        'type' => 'system',
        'status' => null,
    ];

    public const ERROR_SERVER_CONFIGURATION = [
        'httpsCode' => 500,
        'code' => 50,
        'error' => 'ErrorServerConfiguration',
        'description' => 'Ошибка сервера. Обратитесь к Администратору.',
        'troubleshooting' => 'Ошибка сервера. Обратитесь к Администратору.',
        'type' => 'system',
        'status' => null,
    ];

    public const TIMEOUT_FAIL = [
        'httpsCode' => null,
        'code' => 1,
        'error' => null,
        'description' => 'Превышено время ожидания чека в очереди.',
        'troubleshooting' => 'Переданный чек не был обработан. Возможны несколько причин возникновения ошибки: 1. Количество ККТ в группе не соответствует скорости поступления чеков. Необходимо подключить дополнительные ККТ или снизить скорость поступления чеков. 2. Все кассы группы выключены или не активны. Обратитесь к администратору.',
        'type' => 'timeout',
        'status' => 'fail',
    ];
}
