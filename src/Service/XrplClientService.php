<?php declare(strict_types=1);

namespace XrplConnector\Service;

use DateTime;
use Doctrine\DBAL\Connection;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Uuid\Uuid;
use XRPL_PHP\Client\JsonRpcClient;
use XRPL_PHP\Models\Account\AccountTxRequest;
use XrplConnector\Entity\XrplTxEntity;

class XrplClientService
{
    private JsonRpcClient $client;

    public function __construct() {
        $this->_initClient();
    }

    public function fetchAccountTransactions(string $address): array
    {
        $req = new AccountTxRequest($address);
        $res = $this->client->syncRequest($req);

        return $res->getResult()['transactions'];
    }

    /*
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
     */

    private function _initClient()
    {
        $net = 'https://s.altnet.rippletest.net:51234'; // TODO: Pull from const, switch config
        $this->client = new JsonRpcClient($net);
    }
}