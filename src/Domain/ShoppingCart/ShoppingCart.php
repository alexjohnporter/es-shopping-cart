<?php
declare(strict_types=1);

namespace App\Domain\ShoppingCart;

use App\Domain\ShoppingCart\Events\ShoppingCartWasInitialised;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use EventSauce\EventSourcing\AggregateRootId;

class ShoppingCart implements AggregateRoot
{
    use AggregateRootBehaviour;

    public function __construct(private AggregateRootId $aggregateRootId) {}

    public static function initiate(string $shoppingCartId): ShoppingCart
    {
        $aggregateRootId = ShoppingCartId::fromString($shoppingCartId);

        $cart = new static($aggregateRootId);
        $cart->recordThat(new ShoppingCartWasInitialised($aggregateRootId));

        return $cart;
    }

    protected function applyShoppingCartWasInitialised(ShoppingCartWasInitialised $event): void
    {
        //do stuff
    }

}