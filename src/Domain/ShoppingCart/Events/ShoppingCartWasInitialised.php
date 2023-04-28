<?php
declare(strict_types=1);

namespace App\Domain\ShoppingCart\Events;

use App\Domain\ShoppingCart\ShoppingCartId;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

class ShoppingCartWasInitialised implements SerializablePayload
{
    public function __construct(private ShoppingCartId $shoppingCartId) {}
    public function toPayload(): array
    {
        return [
            'id' => $this->shoppingCartId->toString(),
            'created_at' => (new \DateTimeImmutable('now'))->getTimestamp()
        ];
    }

    public static function fromPayload(array $payload): static
    {
        $id = ShoppingCartId::fromString($payload['id']);
        return new ShoppingCartWasInitialised($id);
    }
}