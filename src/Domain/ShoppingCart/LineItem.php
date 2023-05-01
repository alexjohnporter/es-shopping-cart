<?php

namespace App\Domain\ShoppingCart;

class LineItem
{
    private function __construct(
        private string $itemName,
        private int $price
    ) {}

    public function getItemName(): string
    {
        return $this->itemName;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function toPayload(): array
    {
        return [
            'itemName' => $this->itemName,
            'price' => $this->price
        ];
    }

    public static function fromPayload(array $payload): self
    {
        return new self(
            $payload['itemName'],
            $payload['price']
        );
    }
}