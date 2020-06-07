<?php
// src/Service/ProductService.php
namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;


/**
 * Class ProductService
 * @package App\Service
 */
class ProductService
{

    /**
     * @var int
     */
    const LIMIT = 20;
    /**
     * @var ProductRepository
     */
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function generate()
    {
        for ($i = 0; $i < self::LIMIT; $i++) {
            $product = new Product();
            $price = rand(1, 999);
            $name = md5($price);
            $product->setName($name)->setPrice($price);
            $this->repository->save($product);
        }
    }
}
