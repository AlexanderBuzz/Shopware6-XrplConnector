<?php declare(strict_types=1);

namespace XrplConnector\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use XrplConnector\Service\XrplTxService;

class XrplTransactionSyncCommand extends Command
{
    protected static $defaultName = 'xrpl:transaction:sync';

    protected XrplTxService $txService;

    private Connection $connection;

    public function __construct(
        XrplTxService $txService,
        Connection $connection
    ) {
        parent::__construct();

        $this->txService = $txService;
        $this->connection = $connection;
    }

    public function configure()
    {
        parent::configure();

        $this->setDescription('XRPL tx sync');
        $this->addOption('account', null, InputOption::VALUE_OPTIONAL, 'account');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Add DB service instead of connection

        // get account from config or from CLI params
        // fetch account tx
        // on success write to DB
         return Command::SUCCESS;
    }
}