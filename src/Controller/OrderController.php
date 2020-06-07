<?php
// src/Controller/OrderController.php
namespace App\Controller;

use App\Service\OrderService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OrderController
 * @package App\Controller
 */
class OrderController extends BaseController
{
    /**
     * @var OrderService
     */
    private $service;

    /**
     * OrderController constructor.
     * @param OrderService $service
     */
    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/order/create/", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $productIds = $request->request->get('ids', []);
            if (empty($productIds)) {
                throw new \Exception('No product ids in order!');
            }
            $order = $this->service->create($productIds);

            $code = 200;
            $result = $order->getId();

        } catch (\Exception $e) {
            $code = $e->getCode();
            $result = $e->getMessage();
        }

        return $this->json(['result' => $result], $code);
    }

    /**
     * @Route("/order/pay/", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function pay(Request $request)
    {
        try {
            $orderId = (int)$request->request->get('orderId');
            $amount = (float)$request->request->get('amount');
            if (empty($orderId)) {
                throw new NotFoundHttpException('Not found order ID!');
            }
            if (empty($amount)) {
                throw new NotFoundHttpException('Not found amount!');
            }
            $this->service->pay($orderId, $amount);

            $code = 200;
            $result = 'OK';

        } catch (\Exception $e) {
            $code = 500;
            $result = $e->getMessage();
        }

        return $this->json(['result' => $result], $code);
    }
}