<?php declare(strict_types=1);

namespace XrplConnector\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1669402944XrplTx extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1669402944;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('
            CREATE TABLE IF NOT EXISTS `xrpl_connector_tx` (
                `id`            BINARY(16) NOT NULL,
                `server`        ENUM(\'local\', \'dev\', \'test\', \'main\'),
                `hash`          VARCHAR(64) NOT NULL,
                `destination`   VARCHAR(35) NOT NULL,
                `account`       VARCHAR(35) NOT NULL,
                `raw`           TEXT NOT NULL,
                `ledger_index`  VARCHAR(64) NOT NULL,
            )
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
