<?php
declare(strict_types=1);

namespace App\Domain\ShoppingCart;

use EventSauce\EventSourcing\AggregateRootId;

class ShoppingCartId implements AggregateRootId
{
    private function __construct(private string $id) {}

    public function toString(): string
    {
        return $this->id;
    }

    public static function fromString(string $id): static
    {
        return new static($id);
    }
}