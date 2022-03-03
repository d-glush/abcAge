<?php

namespace WarehouseService;

class WarehouseProduct
{
    private int $id;
    private string $name;
    private int $quantity;
    private int $price;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['product_name'];
        $this->quantity = $data['quantity'];
        $this->price = $data['price'];
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
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

    public function getArrayData(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
        ];
    }
}