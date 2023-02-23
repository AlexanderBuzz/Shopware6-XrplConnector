<?php declare(strict_types=1);

namespace XrplConnector\Service;

use DateTime;
use Doctrine\DBAL\Connection;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionEntity;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use XRPL_PHP\Client\JsonRpcClient;
use XRPL_PHP\Models\Account\AccountTxRequest;
use XrplConnector\Entity\XrplTxEntity;
use XrplConnector\Provider\CryptoPriceProviderInterface;

class ConfigurationService
{
    private const DUMMY_NETWORK_ID = 1;

    private SystemConfigService $systemConfigService;

    public function __construct(
        SystemConfigService $systemConfigService
    ) {
        $this->systemConfigService = $systemConfigService;
    }

    public function isTest(): bool
    {
        return true;
    }

   public function getNetwork(): int
   {
        return self::DUMMY_NETWORK_ID;
   }

   public function getDestinationAccount(): string
   {
       if ($this->isTest()) {
           //r9jEyy3nrB8D7uRc5w2k3tizKQ1q8cpeHU
           return $this->systemConfigService->get('XrplConnector.config.testnetAccount');
       }

       return $this->systemConfigService->get('XrplConnector.config.mainnetAccount');
   }
}