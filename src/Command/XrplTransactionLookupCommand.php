<?php declare(strict_types=1);

namespace XrplConnector\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use XrplConnector\Provider\TransactionProviderInterface;

class XrplTransactionLookupCommand extends Command
{
    protected static $defaultName = 'xrpl:transaction:lookup';

    protected TransactionProviderInterface $transactionFinder;

    public function __construct(TransactionProviderInterface $transactionFinder)
    {
        parent::__construct();

        $this->transactionFinder = $transactionFinder;
    }

    public function configure()
    {
        parent::configure();

        $this->setDescription('XRP transaction lookup');
        $this->addOption('transactionID', 'tx', InputOption::VALUE_OPTIONAL, 'transactionID / hash to look for');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $res = $this->transactionFinder->getAccountInfo('rMKBvkKGvbUVSTrULGWhY32fVvq88pZDLp');

        $output->writeln(print_r($res, true));

        return Command::SUCCESS;
    }
}