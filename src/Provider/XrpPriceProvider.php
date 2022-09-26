<?php declare(strict_types=1);

namespace XrplConnector\Provider;

use GuzzleHttp\Client;

class XrpPriceProvider implements CryptoPriceProviderInterface
{
    const ASSET = 'XRP';

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getCurrentPrice(): array
    {
        // TODO: Implement getCurrentPrice() method.

        return [];
    }
}