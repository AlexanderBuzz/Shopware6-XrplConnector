<?php declare(strict_types=1);

namespace XrplConnector\Entity;

use DateTimeInterface;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class TransactionEntity extends Entity
{
    use EntityIdTrait;
    
    protected string $orderId;

    protected string $orderVersionId;

    protected string $xrplTransactionId;

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getOrderVersionId(): string
    {
        return $this->orderVersionId;
    }

    /**
     * @param string $orderVersionId
     */
    public function setOrderVersionId(string $orderVersionId): void
    {
        $this->orderVersionId = $orderVersionId;
    }

    /**
     * @return string
     */
    public function getXrplTransactionId(): string
    {
        return $this->xrplTransactionId;
    }

    /**
     * @param string $xrplTransactionId
     */
    public function setXrplTransactionId(string $xrplTransactionId): void
    {
        $this->xrplTransactionId = $xrplTransactionId;
    }
}