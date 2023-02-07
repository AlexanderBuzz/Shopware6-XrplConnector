<?php declare(strict_types=1);

namespace XrplConnector\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use XrplConnector\Service\XrplTransactionSyncService;

class XrplTransactionSyncCommand extends Command
{
    protected static $defaultName = 'xrpl:transaction:sync';

    protected XrplTransactionSyncService $syncService;

    private Connection $connection;

    public function __construct(
        XrplTransactionSyncService $syncService,
        Connection $connection
    ) {
        parent::__construct();

        $this->syncService = $syncService;
        $this->connection = $connection;
    }

    public function configure()
    {
        parent::configure();

        $this->setDescription('XRP transaction lookup');
        $this->addOption('accountID', 'account', InputOption::VALUE_OPTIONAL, 'account');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $account = 'rPT1Sjq2YGrBMTttX4GZHjKu9dyfzbpAYe';
        $res = $this->syncService->syncAccount();

        return Command::SUCCESS;
    }
}