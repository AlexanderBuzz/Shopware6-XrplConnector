<?php declare(strict_types=1);

namespace XrplConnector\Provider;

use GuzzleHttp\Client;

class XrpPriceProvider implements CryptoPriceProviderInterface
{
    const SYMBOL = 'XRPUSDT';

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getCurrentPrice(): float
    {
        $response = $this->client->get('https://api.binance.com/api/v1/ticker/price?symbol=' . self::SYMBOL);
        $data = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        if (array_key_exists('price', $data)) {
            return (float) $data['price'];
        }

        return 0.00;
    }
}