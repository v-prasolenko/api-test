<?php

namespace App\Entity;

use App\Enum\StatusEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`orders`")
 * @ORM\HasLifecycleCallbacks()
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modified;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="orders", cascade={"persist"})
     */
    private $products;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @return string|null
     */
    public function getStatusLabel(): ?string
    {
        return StatusEnum::getLabel($this->status);
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreated()
    {
        $this->created = new \DateTime();
    }

    /**
     * @ORM\PreFlush
     */
    public function setModified()
    {
        $this->modified = new \DateTime();
    }

    /**
     * @param Product[] $products
     * @return $this
     */
    public function setProducts(array $products): self
    {
        foreach ($products as $product) {
            $product->setOrder($this);
            $this->products->add($product);
        }

        return $this;
    }

    /**
     * @param float $amount
     * @return $this
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}

