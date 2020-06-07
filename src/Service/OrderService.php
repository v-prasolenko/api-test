<?php
// src/Service/OrderService.php
namespace App\Service;

use App\Entity\Order;
use App\Enum\StatusEnum;
use App\Exception\AlreadyPayedOrderException;
use App\Exception\NotCreateOrderException;
use App\Exception\NotFoundOrderException;
use App\Exception\NotFoundProductException;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Class OrderService
 * @package App\Service
 */
class OrderService
{

    /**
     * @var int
     */
    const LIMIT = 20;
    /**
     * @var int
     */
    const CODE_OK = 200;
    /**
     * @var OrderRepository
     */
    private $orders;
    /**
     * @var ProductRepository
     */
    private $products;

    /**
     * OrderService constructor.
     * @param OrderRepository $orderRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository)
    {
        $this->orders = $orderRepository;
        $this->products = $productRepository;
    }

    /**
     * @param array $ids
     * @return Order
     * @throws NotFoundProductException
     * @throws NotCreateOrderException
     */
    public function create(array $ids)
    {
        $ids = array_unique($ids);
        $amount = 0;
        $orderProducts = [];
        foreach ($ids as $id) {
            $product = $this->products->find($id);
            if (!$product) {
                throw new NotFoundProductException(sprintf('Product id #%s not found', $id));
            }
            $orderProducts[] = $product;
            $amount += $product->getPrice();
        }

        return $this->orders->create($orderProducts, $amount);
    }

    /**
     * @param int $orderId
     * @param float $amount
     * @return bool
     * @throws AlreadyPayedOrderException
     * @throws NotFoundOrderException
     */
    public function pay(int $orderId, float $amount)
    {
        $order = $this->orders->find($orderId);
        if (empty($order)) {
            throw new NotFoundOrderException('Order not found!');
        }
        if ($order->getStatus() != StatusEnum::NEW) {
            throw new AlreadyPayedOrderException('Order already payed!');
        }
        if ($order->getAmount() != $amount) {
            throw new NotFoundOrderException('Wrong amount in order!');
        }
        if ($this->isPay($order)) {
            $order->setStatus(StatusEnum::PAY);
            $this->orders->save($order);

            return true;
        }

        return false;
    }

    /**
     * @param Order $order
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function isPay(Order $order)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'http://ya.ru');

        return $response->getStatusCode() == self::CODE_OK;
    }
}
