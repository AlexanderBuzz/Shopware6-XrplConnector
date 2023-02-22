<?php declare(strict_types=1);

namespace XrplConnector\Command;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use XrplConnector\Service\XrplClientService;
use XrplConnector\Service\XrplTxService;

class XrplDatabaseTestCommand extends Command
{
    protected static $defaultName = 'xrpl:database:test';

    protected XrplTxService $txService;

    public function __construct(XrplTxService $txService)
    {
        parent::__construct();

        $this->txService = $txService;
    }

    public function configure()
    {
        parent::configure();

        $this->setDescription('XRP transaction lookup');
        $this->addOption('address', null, InputOption::VALUE_REQUIRED, 'XRPL Address to check for incoming transactions');
        $this->addOption('force', null, InputOption::VALUE_OPTIONAL, 'Truncate table upfront');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $address = $input->getOption('address');

        if ($input->hasOption('force')) {
            $this->txService->resetDatabase();
        }

        $this->txService->syncTransactions($address);

        return Command::SUCCESS;
    }



}