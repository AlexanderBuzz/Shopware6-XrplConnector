<?php declare(strict_types=1);

namespace XrplConnector\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use XrplConnector\Provider\TransactionProviderInterface;
use XrplConnector\Service\XrplTransactionFileService;
use XrplConnector\Service\XrplTransactionSyncService;

class XrplTransactionLookupCommand extends Command
{
    protected static $defaultName = 'xrpl:transaction:lookup';

    protected TransactionProviderInterface $transactionFinder;

    protected XrplTransactionSyncService $syncService;

    protected XrplTransactionFileService $fileService;

    public function __construct(
        TransactionProviderInterface $transactionFinder,
        XrplTransactionSyncService $syncService,
        XrplTransactionFileService $fileService
    ) {
        parent::__construct();

        $this->transactionFinder = $transactionFinder;
        $this->syncService = $syncService;
        $this->fileService = $fileService;
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

        $res = $this->transactionFinder->getAccountTransaction('rGYrnA9UCg5KSMi6tUkxa4rtAFzbfo8J4Y');

        //$this->syncService->handleAccountTransactionResult(json_decode($res, true));
        $this->fileService->saveAccountTxResult($res);

        return Command::SUCCESS;
    }
}