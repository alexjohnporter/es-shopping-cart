<?php
declare(strict_types=1);

namespace App\Domain\ShoppingCart\Events;

use App\Domain\ShoppingCart\ShoppingCartId;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

class ItemQuantityUpdated implements SerializablePayload
{
    public function __construct(
        private string $shoppingCartId,
        private string $itemName,
        private int $quantity
    ) {
    }

    public function toPayload(): array
    {
       return [
           'shoppingCartId' => $this->shoppingCartId,
           'itemName' => $this->itemName,
           'quantity' => $this->quantity
       ];
    }

    public function getItemName(): string
    {
        return $this->itemName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public static function fromPayload(array $payload): static
    {
       return new self(
           $payload['shoppingCartId'],
           $payload['itemName'],
           $payload['quantity']
       );
    }
}