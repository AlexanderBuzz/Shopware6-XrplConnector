<?php declare(strict_types=1);

namespace XrplConnector\Provider;

use GuzzleHttp\Client;

class XrplTransactionProvider implements TransactionProviderInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getTransaction(): array
    {
        // TODO: Implement getCurrentPrice() method.

        return [];
    }
}