<?php

namespace XrplConnector\Components\PaymentHandler;

use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStateHandler;
use Shopware\Core\Checkout\Payment\Cart\AsyncPaymentTransactionStruct;
use Shopware\Core\Checkout\Payment\Cart\PaymentHandler\AsynchronousPaymentHandlerInterface;
use Shopware\Core\Checkout\Payment\Exception\AsyncPaymentProcessException;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use XrplConnector\Provider\CryptoPriceProviderInterface;
use XrplConnector\Service\XrplPaymentTransactionService;

class XrpPaymentHandler implements AsynchronousPaymentHandlerInterface
{
    private RouterInterface $router;

    private OrderTransactionStateHandler $transactionStateHandler;

    private EntityRepository $transactionRepository;

    private CryptoPriceProviderInterface $priceProvider;

    public function __construct(
        RouterInterface              $router,
        OrderTransactionStateHandler $orderTransactionStateHandler,
        EntityRepository             $transactionRepository,
        CryptoPriceProviderInterface $priceProvider
        //XrpltxService $txService
    )
    {
        $this->router = $router;
        $this->transactionStateHandler = $orderTransactionStateHandler;
        $this->transactionRepository = $transactionRepository;
        $this->priceProvider = $priceProvider;
    }

    // https://developer.shopware.com/docs/guides/plugins/plugins/checkout/payment/add-payment-plugin

    /**
     * @param AsyncPaymentTransactionStruct $transaction
     * @param RequestDataBag $dataBag
     * @param SalesChannelContext $salesChannelContext
     * @return RedirectResponse
     */
    public function pay(AsyncPaymentTransactionStruct $transaction, RequestDataBag $dataBag, SalesChannelContext $salesChannelContext): RedirectResponse
    {
        $orderTransaction = $transaction->getOrderTransaction();
        $existingCustomFields = $orderTransaction->getCustomFields() ?? [];

        $destination = 'r9jEyy3nrB8D7uRc5w2k3tizKQ1q8cpeHU'; // TODO: From config
        $destinationTag = $this->generateDestinationTag();
        $order = $transaction->getOrder();
        $xrpAmount = $this->priceProvider->getCurrentPriceForOrder($order, $salesChannelContext->getContext());

        // TODO: Validate XRP amount

        $customFields = [
            'xrpl' => [
                'type' => 'xrp-payment',
                'destination' => $destination,
                'destination_tag' => $destinationTag, // TODO: Use consistent naming or use separate service
                'amount' => $xrpAmount
            ]
        ];

        //In case that the cache kicks in update the current struct either to avoid any misbehavior when working with custom fields in later steps.
        $transaction->getOrderTransaction()->setCustomFields(array_merge($existingCustomFields, $customFields));

        $this->transactionRepository->upsert([
            [
                'id' => $orderTransaction->getId(),
                'customFields' => $customFields,
            ],
        ], $salesChannelContext->getContext());

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

    private function generateDestinationTag(): int
    {
        // TODO: Generate int without collision
        return 10123;
    }
}