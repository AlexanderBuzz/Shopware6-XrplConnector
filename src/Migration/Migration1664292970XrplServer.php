<?php declare(strict_types=1);

namespace XrplConnector\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1664292970XrplServer extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1664292970;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('
            CREATE TABLE IF NOT EXISTS `xrpl_connector_server` (
                `id`            BINARY(16) NOT NULL,
                `name`          VARCHAR(255) NOT NULL,
                `env_type`      ENUM(\'local\', \'dev\', \'test\', \'main\'),
                `query_type`      ENUM(\'WebSocket\', \'JSON-RPC\'),
                `address`       VARCHAR(255) NOT NULL
            )
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
