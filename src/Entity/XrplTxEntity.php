<?php declare(strict_types=1);

namespace XrplConnector\Entity;

use DateTimeInterface;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class XrplTxEntity extends Entity
{
    use EntityIdTrait;


    protected string $hash;

    protected string $server;

    protected string $destination;

    protected string $account;

    protected string $raw;

    protected string $ledgerIndex;

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getServer(): string
    {
        return $this->server;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @return string
     */
    public function getAccount(): string
    {
        return $this->account;
    }

    /**
     * @return string
     */
    public function getRaw(): string
    {
        return $this->raw;
    }

    /**
     * @return string
     */
    public function getLedgerIndex(): string
    {
        return $this->ledgerIndex;
    }
}