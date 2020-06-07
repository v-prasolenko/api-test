<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\Product;
use App\Enum\StatusEnum;
use App\Exception\NotCreateOrderException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * OrderRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($registry, Order::class);
    }

    /**
     * @param Product[] $products
     * @param int $amount
     * @return Order
     * @throws NotCreateOrderException
     */
    public function create(array $products, int $amount): Order
    {
        try {
            $order = new Order();
            $order->setStatus(StatusEnum::NEW)
                ->setAmount($amount)
                ->setProducts($products);

            $this->entityManager->persist($order);
            $this->entityManager->flush();
        } catch (Exception $e) {
            throw new NotCreateOrderException($e->getMessage());
        }

        return $order;
    }

    /**
     * @param Order $order
     */
    public function save(Order $order)
    {
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }
}
