<?php declare(strict_types=1);

namespace XrplConnector\Provider;

interface CryptoPriceProviderInterface
{
    public function getCurrentExchangeRate(string $code): float;

    public function checkPricePlausibility(float $price): bool;
}