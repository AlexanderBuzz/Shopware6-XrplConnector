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
use XRPL_PHP\Client\JsonRpcClient;
use XRPL_PHP\Models\Account\AccountTxRequest;
use XrplConnector\Entity\XrplTxEntity;

class OrderTransactionService
{
    private EntityRepository $orderRepository;

    private XrplTxService $xrplSyncService;
    public function __construct(
        EntityRepository $orderRepository,
        XrplTxService $xrplSyncService
    ) {
        $this->orderRepository = $orderRepository;
        $this->xrplSyncService = $xrplSyncService;
    }

    public function getOrderWithTransactions(string $orderId, Context $context): ?OrderEntity
    {
        $criteria = new Criteria([$orderId]);
        $criteria->addAssociation('transactions');
        $criteria->getAssociation('transactions')->addSorting(new FieldSorting('createdAt'));

        return $this->orderRepository->search(
            $criteria,
            $context
        )->first();
    }

    public function syncOrderTransactionWithXrpl(OrderTransactionEntity $orderTransaction): ?array
    {
        $customFields = $orderTransaction->getCustomFields();
        if (isset($customFields['xrpl']['destination']) && isset($customFields['xrpl']['destination_tag'])) {

            // TODO: Exception when orderTransaction.customFields are different form xrpl_tx

            $tx = $this->xrplSyncService->findTransaction(
                $customFields['xrpl']['destination'],
                (int) $customFields['xrpl']['destination_tag']
            );

            if ($tx) {
                return $tx;
            }

            $this->xrplSyncService->syncTransactions($customFields['xrpl']['destination']);

            return $this->xrplSyncService->findTransaction(
                $customFields['xrpl']['destination'],
                (int) $customFields['xrpl']['destination_tag']
            );
        }

        return null;
    }
}