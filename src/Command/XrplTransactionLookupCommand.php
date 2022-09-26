<?php declare(strict_types=1);

namespace XrplConnector\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use XrplConnector\Provider\TransactionProviderInterface;
use XrplConnector\Service\XrplTransactionSyncService;

class XrplTransactionLookupCommand extends Command
{
    protected static $defaultName = 'xrpl:transaction:lookup';

    protected TransactionProviderInterface $transactionFinder;

    protected XrplTransactionSyncService $syncService;

    public function __construct(
        TransactionProviderInterface $transactionFinder,
        XrplTransactionSyncService $syncService
    ) {
        parent::__construct();

        $this->transactionFinder = $transactionFinder;
        $this->syncService = $syncService;
    }

    public function configure()
    {
        parent::configure();

        $this->setDescription('XRP transaction lookup');
        $this->addOption('transactionID', 'tx', InputOption::VALUE_OPTIONAL, 'transactionID / hash to look for');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //Standby Account: 'rMKBvkKGvbUVSTrULGWhY32fVvq88pZDLp'
        //OperationalAccount: 'rwif7LDjdrRVUUPeeeY3FPNWHn1JPWyKkv'

        $res = $this->transactionFinder->getAccountTransaction('rwif7LDjdrRVUUPeeeY3FPNWHn1JPWyKkv');

        $this->syncService->handleAccountTransactionResult($res);
        //$output->writeln(print_r($res, true));

        return Command::SUCCESS;
    }
}