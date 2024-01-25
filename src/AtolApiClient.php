<?php

declare(strict_types=1);

namespace Vlsv\AtolOnline;

use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;
use Psr\SimpleCache\CacheInterface;
use SplObjectStorage;
use SplSubject;
use Symfony\Component\Serializer\Serializer;
use Vlsv\AtolOnline\Api\Trait\BuyCorrectionTrait;
use Vlsv\AtolOnline\Api\Trait\BuyRefundTrait;
use Vlsv\AtolOnline\Api\Trait\BuyTrait;
use Vlsv\AtolOnline\Api\Trait\GetTokenTrait;
use Vlsv\AtolOnline\Api\Trait\OperationTrait;
use Vlsv\AtolOnline\Api\Trait\ReportTrait;
use Vlsv\AtolOnline\Api\Trait\RequestTrait;
use Vlsv\AtolOnline\Api\Trait\SellCorrectionTrait;
use Vlsv\AtolOnline\Api\Trait\SellRefundTrait;
use Vlsv\AtolOnline\Api\Trait\SellTrait;
use Vlsv\AtolOnline\Api\Trait\SplObserverTrait;
use Vlsv\AtolOnline\Factory\SerializerFactory;

/**
 * @package Vlsv\AtolOnline
 * @author  Evgeny Vlasov <vlasov.evgeny@gmail.com>
 */
class AtolApiClient implements SplSubject
{
    use SplObserverTrait;
    use RequestTrait;
    use GetTokenTrait;
    use OperationTrait;
    use SellTrait;
    use SellRefundTrait;
    use SellCorrectionTrait;
    use BuyTrait;
    use BuyRefundTrait;
    use BuyCorrectionTrait;
    use ReportTrait;

    protected Serializer $serializer;

    protected SplObjectStorage $observers;

    public function __construct(
        /** Объект с параметрами аккаунта АТОЛ */
        private AtolAccount $atolAccount,

        /** Http клиент */
        protected ClientInterface $client = new Client(),

        /** Объект кеша совместимый с PSR-16 */
        protected null|CacheInterface $cache = null,

        /** Ttl элемента */
        protected int $cacheKeyTokenTtlSec = 43200,

        /** Префикс ключа */
        protected string $cacheKeyTokenPrefix = 'Vlsv.AtolOnline.',
    ) {
        $this->serializer = SerializerFactory::getSerializer();
        $this->observers = new SplObjectStorage();
    }

    public function getSerializer(): Serializer
    {
        return $this->serializer;
    }

    public function setAtolAccount(AtolAccount $atolAccount): static
    {
        $this->atolAccount = $atolAccount;

        return $this;
    }

    public function getAtolAccount(): AtolAccount
    {
        return $this->atolAccount;
    }

    public function setCache(CacheInterface $object): static
    {
        $this->cache = $object;

        return $this;
    }

    public function getCache(): CacheInterface
    {
        return $this->cache;
    }

    public function getCacheKey(): string
    {
        return $this->cacheKeyTokenPrefix
            . $this->getAtolAccount()->getGroupCode() . '.'
            . $this->getAtolAccount()->getLogin();
    }
}
