<?php
declare(strict_types=1);

namespace App\Domain\ShoppingCart\Events;

use App\Domain\ShoppingCart\LineItem;
use App\Domain\ShoppingCart\ShoppingCartId;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

class ItemAddedToCart implements SerializablePayload
{
    public function __construct(
        private string $shoppingCartId,
        private LineItem $lineItem
    ) {
    }

    public function getLineItem(): LineItem
    {
        return $this->lineItem;
    }

    public function getShoppingCartId(): string
    {
        return $this->shoppingCartId;
    }

    public function toPayload(): array
    {
        return [
            'shoppingCartId' => $this->shoppingCartId,
            'lineItem' => $this->lineItem->toPayload()
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new self(
            $payload['shoppingCartId'],
            LineItem::fromPayload($payload['lineItem'])
        );
    }
}
