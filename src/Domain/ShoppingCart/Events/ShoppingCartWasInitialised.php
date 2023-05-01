<?php
declare(strict_types=1);

namespace App\Domain\ShoppingCart\Events;

use App\Domain\ShoppingCart\ShoppingCartId;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

class ShoppingCartWasInitialised implements SerializablePayload
{
    public function __construct(
        private ShoppingCartId $shoppingCartId,
        private string $status
    ) {}
    public function toPayload(): array
    {
        return [
            'id' => $this->shoppingCartId->toString(),
            'created_at' => $this->getCreatedAt()->getTimestamp(),
            'status' => $this->status
        ];
    }

    public static function fromPayload(array $payload): static
    {
        $id = ShoppingCartId::fromString($payload['id']);
        return new ShoppingCartWasInitialised($id, $payload['status']);
    }


    public function getShoppingCartId(): ShoppingCartId
    {
        return $this->shoppingCartId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    //I'd pass this in from the AggregrateRoot in real life
    public function getCreatedAt(): \DateTimeInterface
    {
        return new \DateTimeImmutable('now');
    }
}