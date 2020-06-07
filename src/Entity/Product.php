<?php
// src/Entity/Product.php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(name="`products`")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;


    /**
     * @ORM\ManyToMany(targetEntity="Order", inversedBy="orders")
     */
    private $orders;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->orders->add($order);
    }
}
