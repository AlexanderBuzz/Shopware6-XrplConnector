<?php declare(strict_types=1);

namespace XrplConnector\Storefront\Controller;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class XrpPaymentController extends StorefrontController
{
    private EntityRepository $orderRepository;

    public function __construct(
        EntityRepository $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @Route("/xrpl-connector/payment/{orderId}", name="frontend.checkout.xrpl-connector.payment", options={"seo"="false"}, methods={"GET", "POST"})
     */
    public function payment(SalesChannelContext $context, Request $request)
    {
        $orderId = $request->request->get('my_parameter');
        $order = $this->orderRepository->search(new Criteria([$orderId]), $context->getContext())->first();

        return $this->renderStorefront('@Storefront/storefront/xrpl-connector/payment.html.twig', [
            'returnUrl' => $request->get('returnUrl'),
            'orderId' => $orderId,
            'orderNumber' => $order->getOrderNumber(),
            'xrpAmount' => 123, //TODO: From PriceProvider!
            'showNoTransactionFoundError' => true
        ]);
    }

}