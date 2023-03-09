<?php declare(strict_types=1);

namespace XrplConnector\Service;

use XRPL_PHP\Core\Networks;
use Shopware\Core\System\SystemConfig\SystemConfigService;

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

   public function getDestinationAccount(): string
   {
       if ($this->isTest()) {
           //r9jEyy3nrB8D7uRc5w2k3tizKQ1q8cpeHU
           return $this->systemConfigService->get('XrplConnector.config.testnetAccount');
       }

       return $this->systemConfigService->get('XrplConnector.config.mainnetAccount');
   }
}