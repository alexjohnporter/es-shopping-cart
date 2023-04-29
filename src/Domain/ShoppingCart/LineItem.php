<?php

namespace App\Domain\ShoppingCart;

class LineItem
{
    private function __construct(
        private string $itemName,
        private int $quantity,
        private int $price
    ) {}

    public function getItemName(): string
    {
        return $this->itemName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function updateQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function toPayload(): array
    {
        return [
            'itemName' => $this->itemName,
            'quantity' => $this->quantity,
            'price' => $this->price
        ];
    }

    public static function fromPayload(array $payload): self
    {
        return new self(
            $payload['itemName'],
            $payload['quantity'],
            $payload['price']
        );
    }
}