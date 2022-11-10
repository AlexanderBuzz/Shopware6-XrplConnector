<?php declare(strict_types=1);

namespace XrplConnector\Service;

use DateTime;
use SaferPaySw6\Entity\TransactionEntity;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Uuid\Uuid;

class XrplPaymentTransactionService
{
    private EntityRepository $transactionRepository;

    public function __construct(
        EntityRepository $transactionRepository
    ) {
        $this->transactionRepository = $transactionRepository;
    }

    public function findTransaction(string $xrplInvoiceId, Context $context): TransactionEntity
    {
        $transactionCriteria = (new Criteria())->addFilter(new EqualsFilter('xrplInvoiceId', $xrplInvoiceId));
        $transactionResult = $this->transactionRepository->search($transactionCriteria, $context);

        if($transactionResult->count() === 0) {
            //No transaction found
        }

        return $transactionResult->first();
    }

    public function handleTransactionCreation(
        OrderEntity $order,
        string $redirectUrl,
        Context $context
    ): void
    {
        $xrplInvoiceId = hash('sha256', $order->getOrderNumber()); //TODO: check if this fits XRPL Hash256 Type
        $expiration = (new DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT);

        $this->transactionRepository->create([
            [
                'id' => Uuid::randomHex(),
                'orderId' => $order->getId(),
                'orderVersionId' => $order->getVersionId(),
                'xrplTransactionId' => null,
                'xrplInvoiceId' => $xrplInvoiceId,
                'expiration' => (new DateTime($expiration))->format(Defaults::STORAGE_DATE_TIME_FORMAT),
                'redirectUrl' => $redirectUrl,
            ]
        ], $context);
    }

    public function handleTransactionUpdate(
        TransactionEntity $transaction,
        string $xrplTransactionId,
        Context $context
    ): void
    {
        $this->transactionRepository->update([
            [
                'id' => $transaction->getId(),
                'orderId' => $transaction->getOrderId(),
                'orderVersionId' => $transaction->getOrderVersionId(),
                'xrplTransactionId' => $xrplTransactionId
            ]
        ], $context);
    }

    public function extractPaymentToken($returnUrl): string
    {
        list($junk, $token) = explode('_sw_payment_token=', $returnUrl);

        return $token;
    }
}