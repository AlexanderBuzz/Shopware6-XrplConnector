<?php declare(strict_types=1);

namespace XrplConnector\Service;

use Doctrine\DBAL\Connection;
use GuzzleHttp\Promise\PromiseInterface;
use XRPL_PHP\Client\JsonRpcClient;

class XrplTransactionSyncService
{
    private JsonRpcClient $client;

    private Connection $connection;

    public function __construct(
        JsonRpcClient $client,
        Connection $connection
    ) {
        $this->client = $client;
        $this->connection = $connection;
    }

    public function getLastSyncedLedgerIndex(string $account): string
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('MAX(ledger_index)')
            ->from('xrpl_tx')
            ->where('destination = ?')
            ->setParameter(0, $account)
        ;

    }

    /* Example tx, see https://xrpl.org/tx.html
     * [tx] => Array
     * (
     * [Account] => rMKBvkKGvbUVSTrULGWhY32fVvq88pZDLp
     * [Amount] => 100000000
     * [Destination] => rwif7LDjdrRVUUPeeeY3FPNWHn1JPWyKkv
     * [Fee] => 12
     * [Flags] => 0
     * [LastLedgerSequence] => 5971947
     * [Sequence] => 5968419
     * [SigningPubKey] => EDD4F2F0FFFD72E315CEB61B91CD79337DED75C1C9544A71455B432EC4A51A05CA
     * [TransactionType] => Payment
     * [TxnSignature] => 66BA1A8731155712F55FB45F55BAB35A15874E26B9203D82215F7F28550A9F9F27015961A64F290733D672299413FF00829285426284CC1F19C34A0C238F5100
     * [date] => 717521350
     * [hash] => 43A6FCD81EE67694F6D3E7D56D41646CB9F7D9765DDBF61CFC39BBEC4F99B59C
     * [inLedger] => 5971929 //deprecated, is now [ledger_index]
     * [ledger_index] => 5971929
     * )
     */

    public function handleAccountTransactionResult(array $accountTransactionResult): void
    {
        foreach ($accountTransactionResult['result']['transactions'] as $tx) {
            //TODO: This output needs to be synced to the database
            print_r($tx);
        }
    }

    private function fetch(): PromiseInterface
    {

    }
}