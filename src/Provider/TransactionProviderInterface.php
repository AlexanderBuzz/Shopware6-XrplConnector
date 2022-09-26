<?php declare(strict_types=1);

namespace XrplConnector\Provider;

interface TransactionProviderInterface
{
    public function getTransaction(): array;
}