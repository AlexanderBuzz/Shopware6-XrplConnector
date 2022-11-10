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

    protected ?string $xrplTransactionId;

    protected ?string $xrplInvoiceId;

    protected DateTimeInterface $expirationDate;

    protected float $xrpAmount;

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

    /**
     * @return string|null
     */
    public function getXrplInvoiceId(): ?string
    {
        return $this->xrplInvoiceId;
    }

    /**
     * @param string|null $xrplInvoiceId
     */
    public function setXrplInvoiceId(?string $xrplInvoiceId): void
    {
        $this->xrplInvoiceId = $xrplInvoiceId;
    }

    /**
     * @return DateTimeInterface
     */
    public function getExpirationDate(): DateTimeInterface
    {
        return $this->expirationDate;
    }

    /**
     * @param DateTimeInterface $expirationDate
     */
    public function setExpirationDate(DateTimeInterface $expirationDate): void
    {
        $this->expirationDate = $expirationDate;
    }

    /**
     * @return float
     */
    public function getXrpAmount(): float
    {
        return $this->xrpAmount;
    }

    /**
     * @param float $xrpAmount
     */
    public function setXrpAmount(float $xrpAmount): void
    {
        $this->xrpAmount = $xrpAmount;
    }
}