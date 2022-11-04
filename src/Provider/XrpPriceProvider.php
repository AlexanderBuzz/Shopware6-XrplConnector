<?php declare(strict_types=1);

namespace XrplConnector\Provider;

use GuzzleHttp\Client;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\CustomEntity\Xml\Entity;

class XrpPriceProvider implements CryptoPriceProviderInterface
{
    const SYMBOL = 'XRPUSDT';

    private Client $client;

    private EntityRepository $orderTransactionRepository;

    private EntityRepository $currencyRepository;

    public function __construct(
        Client $client,
        EntityRepository $orderTransactionRepository,
        EntityRepository $currencyRepository
    ) {
        $this->client = $client;
        $this->orderTransactionRepository = $orderTransactionRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function getCurrentPrice(?string $iso = self::SYMBOL): float
    {
        $response = $this->client->get('https://api.binance.com/api/v1/ticker/price?symbol=' . self::SYMBOL);
        $data = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        if (array_key_exists('price', $data)) {
            return (float) $data['price'];
        }

        return 0;
    }

    public function getCurrentPriceForOrder(OrderEntity $order, Context $context): float
    {
        $amountTotal = $order->getAmountTotal();

        $currency = $this->currencyRepository->search(new Criteria([$order->getCurrencyId()]), $context)->first();
        $xrpUnitPrice = $this->getCurrentPrice($currency->getIsoCode());

        return $amountTotal / $xrpUnitPrice;
    }
}