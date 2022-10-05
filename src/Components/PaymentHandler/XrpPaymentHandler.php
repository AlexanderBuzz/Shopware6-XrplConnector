<?php

namespace XrplConnector\Components\PaymentHandler;

use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStateHandler;
use Shopware\Core\Checkout\Payment\Cart\AsyncPaymentTransactionStruct;
use Shopware\Core\Checkout\Payment\Cart\PaymentHandler\AsynchronousPaymentHandlerInterface;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class XrpPaymentHandler implements AsynchronousPaymentHandlerInterface
{
    public function __construct(
        OrderTransactionStateHandler $orderTransactionStateHandler
    ) {
        $this->transactionStateHandler = $orderTransactionStateHandler;
    }

    public function pay(AsyncPaymentTransactionStruct $transaction, RequestDataBag $dataBag, SalesChannelContext $salesChannelContext): RedirectResponse
    {
        $transactionId = $transaction->getOrderTransaction()->getId();

        /* 5.6
         * $payment = $this->Request()->getPost('payment'); "5"
         *
         * Shopware()->Modules()->Admin()->sSYSTEM->_POST['sPayment'] = $payment;
         *
         *         if ($checkData['sPaymentObject'] instanceof \ShopwarePlugin\PaymentMethods\Components\BasePaymentMethod) {
            $checkData['sPaymentObject']->savePaymentData(Shopware()->Session()->sUserId, $this->Request());
        }

                $this->redirect([
            'controller' => $this->Request()->getParam('sTarget', 'checkout'),
            'action' => $this->Request()->getParam('sTargetAction', 'confirm'),
        ]);
         */


    }

    public function finalize(AsyncPaymentTransactionStruct $transaction, Request $request, SalesChannelContext $salesChannelContext): void
    {
        // TODO: Implement finalize() method.
    }
}