<?php declare(strict_types=1);

namespace XrplConnector\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1667583695OrderXrplTransaction extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1664293006;
    }

    public function update(Connection $connection): void
    {
        //TODO: Implement function
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
