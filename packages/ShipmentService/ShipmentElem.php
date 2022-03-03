<?php

namespace ShipmentService;

use DateTime;

class ShipmentElem
{
    private int $id;
    private string $number;
    private string $productName;
    private int $quantity;
    private int $price;
    private DateTime $date;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->number = $data['number'];
        $this->productName = $data['product_name'];
        $this->quantity = $data['quantity'];
        $this->price = $data['price'];
        $this->date = new DateTime($data['date']);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;
        return $this;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): self
    {
        $this->date = $date;
        return $this;
    }
}