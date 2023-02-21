<?php declare(strict_types=1);

namespace XrplConnector\Storefront\Controller;

use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use XrplConnector\Provider\CryptoPriceProviderInterface;
use XrplConnector\Service\OrderTransactionService;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class XrpPaymentController extends StorefrontController
{
    private CryptoPriceProviderInterface $priceProvider;

    private OrderTransactionService $orderTransactionService;

    public function __construct(
        CryptoPriceProviderInterface $priceProvider,
        OrderTransactionService $orderTransactionService
    ) {
        $this->priceProvider = $priceProvider;
        $this->orderTransactionService = $orderTransactionService;
    }

    /**
     * @Route("/xrpl-connector/payment/{orderId}", name="frontend.checkout.xrpl-connector.payment", options={"seo"="false"}, methods={"GET", "POST"})
     */
    public function payment(SalesChannelContext $context, string $orderId, Request $request)
    {
        $order = $this->orderTransactionService->getOrderById($orderId, $context->getContext());

        $orderTransaction = $order->getTransactions()->first();
        $customFields = $orderTransaction->getCustomFields();
        $destinationTag = $customFields['xrpl']['destination_tag']; // TODO: Use consistent naming or use separate service

        $returnUrl = $request->get('returnUrl');

        $totalXrpAmount = $this->priceProvider->getCurrentPriceForOrder($order, $context->getContext());

        // https://goqr.me/api/doc/create-qr-code/

        return $this->renderStorefront('@Storefront/storefront/xrpl-connector/payment.html.twig', [
            'destinationAccount' => 'r9jEyy3nrB8D7uRc5w2k3tizKQ1q8cpeHU',
            'destinationTag' => $destinationTag,
            'orderId' => $orderId,
            'orderNumber' => $order->getOrderNumber(),
            'returnUrl' => $returnUrl,
            'showNoTransactionFoundError' => true,
            'xrpAmount' => $totalXrpAmount
        ]);
    }

    /**
     * @Route("/xrpl-connector/check-payment/{orderId}", name="frontend.checkout.xrpl-connector.check-payment", defaults={"XmlHttpRequest"=true}, methods={"GET", "POST"})
     */
    public function checkPayment(SalesChannelContext $context,  string $orderId, Request $request): JsonResponse
    {
        $order = $this->orderTransactionService->getOrderById($orderId, $context->getContext());

        if ($order) {
            $orderTransaction = $order->getTransactions()->first();
            $customFields = $orderTransaction->getCustomFields();

            if (isset($customFields['xrpl'])) {
                $destination = 'r9jEyy3nrB8D7uRc5w2k3tizKQ1q8cpeHU'; // TODO: Pull from config
                $destinationTag = $customFields['xrpl']['destination_tag'];
                $amount = $customFields['xrpl']['amount']; // TODO: Check für validity

                // Sync Tx'es
                // Get Tx from Service
                // If dest, tag and amount match, retzurn success

                return new JsonResponse(['success' => true]);
            }
        }

        return new JsonResponse(['success' => false]);
    }

}