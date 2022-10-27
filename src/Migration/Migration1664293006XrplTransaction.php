<?php declare(strict_types=1);

namespace XrplConnector\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1664293006XrplTransaction extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1664293006;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('
            CREATE TABLE IF NOT EXISTS `xrpl_connector_transaction` (
                `id`            BINARY(16) NOT NULL,
                `hash`          VARCHAR(64) NOT NULL,
                `account`       VARCHAR(44) NOT NULL,
                `destination`   VARCHAR(44) NOT NULL,
                `amount`        VARCHAR(64) NOT NULL,
                `tx_type`       ENUM(\'local\', \'dev\', \'test\', \'main\'),
                `query_type`    ENUM(\'WebSocket\', \'JSON-RPC\'),
                `address`       VARCHAR(255) NOT NULL
            )
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
