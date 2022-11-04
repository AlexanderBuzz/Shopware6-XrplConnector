<?php declare(strict_types=1);

namespace XrplConnector\Provider;

interface CryptoPriceProviderInterface
{
    public function getCurrentPrice(?string $iso = null): float;
}