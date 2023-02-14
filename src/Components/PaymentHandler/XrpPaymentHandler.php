<?php

namespace XrplConnector\Components\PaymentHandler;

use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStateHandler;
use Shopware\Core\Checkout\Payment\Cart\AsyncPaymentTransactionStruct;
use Shopware\Core\Checkout\Payment\Cart\PaymentHandler\AsynchronousPaymentHandlerInterface;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use XrplConnector\Service\XrplPaymentTransactionService;

class XrpPaymentHandler implements AsynchronousPaymentHandlerInterface
{
    private RouterInterface $router;

    private OrderTransactionStateHandler $transactionStateHandler;

    private XrplPaymentTransactionService $transactionService;

    public function __construct(
        RouterInterface $router,
        OrderTransactionStateHandler $orderTransactionStateHandler,
        XrplPaymentTransactionService $transactionService
    ) {
        $this->router = $router;
        $this->transactionStateHandler = $orderTransactionStateHandler;
        $this->transactionService = $transactionService;
    }

    public function pay(AsyncPaymentTransactionStruct $transaction, RequestDataBag $dataBag, SalesChannelContext $salesChannelContext): RedirectResponse
    {
        $orderTransaction = $transaction->getOrderTransaction();
        $order = $transaction->getOrder();

        $redirectUrl = $this->router->generate('frontend.checkout.xrpl-connector.payment', [
            'orderId' => $transaction->getOrder()->getId(),
            'returnUrl' => $transaction->getReturnUrl()
        ]);
        return new RedirectResponse($redirectUrl);
    }

    public function finalize(AsyncPaymentTransactionStruct $transaction, Request $request, SalesChannelContext $salesChannelContext): void
    {
        $paymentState = $request->query->getAlpha('status');
        $context = $salesChannelContext->getContext();
        if ($paymentState === 'completed') {
            // Payment completed, set transaction status to "paid"
            $this->transactionStateHandler->paid($transaction->getOrderTransaction()->getId(), $context);
        } else {
            // Payment not completed, set transaction status to "open"
            $this->transactionStateHandler->reopen($transaction->getOrderTransaction()->getId(), $context);
        }
    }
}