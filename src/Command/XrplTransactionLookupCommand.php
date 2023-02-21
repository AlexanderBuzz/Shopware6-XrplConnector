<?php declare(strict_types=1);

namespace XrplConnector\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use XrplConnector\Service\XrplTransactionFileService;
use XrplConnector\Service\XrplTxService;

class XrplTransactionLookupCommand extends Command
{
    protected static $defaultName = 'xrpl:transaction:lookup';

    protected XrplTxService $syncService;

    protected XrplTransactionFileService $fileService;

    public function __construct(
        XrplTxService $txService,
        XrplTransactionFileService $fileService
    ) {
        parent::__construct();

        $this->txService = $txService;
        $this->fileService = $fileService;
    }

    public function configure()
    {
        parent::configure();

        $this->setDescription('XRP transaction lookup');
        $this->addOption('hash', null, InputOption::VALUE_OPTIONAL, 'Hash identifying a tx');
        $this->addOption('ctid', null, InputOption::VALUE_OPTIONAL, 'CTID identifying a validated tx');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $hash = $input->getOption('hash');
        $ctid  = $input->getOption('ctid');

        if ($hash xor $ctid) {
            $output->writeln('hash: ' . $hash);
            $output->writeln('ctid: ' . $ctid);

            //$this->fileService->saveAccountTxResult($res);

            return Command::SUCCESS;
        }

        $output->writeln('Either a --hash or a --ctid is required as a parameter');

        return Command::FAILURE;
    }
}