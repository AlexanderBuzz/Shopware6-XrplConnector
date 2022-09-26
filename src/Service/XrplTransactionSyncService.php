<?php declare(strict_types=1);

namespace XrplConnector\Service;

class XrplTransactionSyncService
{
    public function __construct()
    {

    }

    public function handleAccountTransactionResult(array $accountTransactionResult): void
    {
        foreach ($accountTransactionResult['result']['transactions'] as $tx) {
            //TODO: This output needs to be synced to the database
            print_r($tx);
        }
    }
}