<?php declare(strict_types=1);

namespace XrplConnector\Storefront\Controller;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use XrplConnector\Provider\CryptoPriceProviderInterface;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class XrpPaymentController extends StorefrontController
{
    private CryptoPriceProviderInterface $priceProvider;

    private EntityRepository $orderRepository;

    public function __construct(
        CryptoPriceProviderInterface $priceProvider,
        EntityRepository $orderRepository
    ) {
        $this->priceProvider = $priceProvider;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @Route("/xrpl-connector/payment/{orderId}", name="frontend.checkout.xrpl-connector.payment", options={"seo"="false"}, methods={"GET", "POST"})
     */
    public function payment(SalesChannelContext $context, Request $request)
    {
        $orderId = $request->get('orderId');
        $order = $this->orderRepository->search(new Criteria([$orderId]), $context->getContext())->first();

        $totalXrpAmount = $this->priceProvider->getCurrentPriceForOrder($order, $context->getContext());

        // https://goqr.me/api/doc/create-qr-code/

        return $this->renderStorefront('@Storefront/storefront/xrpl-connector/payment.html.twig', [
            'returnUrl' => $request->get('returnUrl'),
            'orderId' => $orderId,
            'orderNumber' => $order->getOrderNumber(),
            'xrpAmount' => $totalXrpAmount,
            'showNoTransactionFoundError' => true
        ]);
    }

}