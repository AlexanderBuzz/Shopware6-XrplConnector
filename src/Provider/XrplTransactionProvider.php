<?php declare(strict_types=1);

namespace XrplConnector\Provider;

use GuzzleHttp\Client;

class XrplTransactionProvider implements TransactionProviderInterface
{
    private Client $client;

    private const TESTNET_URI = 'http://xls20-sandbox.rippletest.net:51234';

    private string $endpoint;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->endpoint = self::TESTNET_URI;
    }

    public function getAccountInfo(string $account): array
    {
        $body = $this->createRequestBody('account_info', [
            'account' => $account, //account taken from official xrpl.org documentation example
            'strict' => true,
            'ledger_index' => 'current',
            'queue' => true
        ]);

        //TODO: Async
        $res = $this->client->request('POST', $this->endpoint, $body);

        //print_r($res->getStatusCode());
        //print_r((string)$res->getBody());

        return json_decode((string)$res->getBody(), true);
    }

    public function getAccountTransaction(string $account): string
    {
        $body = $this->createRequestBody('account_tx', [
            "account" => $account,
            "ledger_index_min" => -1,
            "ledger_index_max" => -1,
            "binary" => false,
            "forward"=> false
        ]);

        //TODO: Async
        $res = $this->client->request('POST', $this->endpoint, $body);

        return (string)$res->getBody();
    }

    public function getTransaction(string $transactionId): array
    {
        $body = $this->createRequestBody('tx', [
            'transaction' => $transactionId,
            'binary' => false
        ]);

        //TODO: Async
        $res = $this->client->request('POST', $this->endpoint, $body);

        return json_decode((string)$res->getBody(), true);
    }

    private function createRequestBody(string $method, array $params): array
    {
        return [
            'http_errors' => true,
            'connect_timeout' => 10,
            'body' => json_encode([
                'method' => $method,
                'params' => [$params]
            ]),
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ];
    }
}