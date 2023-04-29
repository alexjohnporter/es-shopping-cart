<?php
declare(strict_types=1);

namespace App\Domain\ShoppingCart;

use App\Application\AddItemToCart;
use App\Domain\ShoppingCart\Events\ItemAddedToCart;
use App\Domain\ShoppingCart\Events\ItemQuantityUpdated;
use App\Domain\ShoppingCart\Events\ShoppingCartWasInitialised;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use EventSauce\EventSourcing\AggregateRootId;

class ShoppingCart implements AggregateRoot
{
    use AggregateRootBehaviour;

    public function __construct(
        private AggregateRootId $aggregateRootId,
        private array           $lineItems = []
    )
    {
    }

    public static function initiate(string $shoppingCartId): ShoppingCart
    {
        $aggregateRootId = ShoppingCartId::fromString($shoppingCartId);

        $cart = new static($aggregateRootId);
        $cart->recordThat(new ShoppingCartWasInitialised($aggregateRootId));

        return $cart;
    }

    public function addItem(LineItem $lineItem): ShoppingCart
    {
        $existingLineItem = $this->getItemFromCart($lineItem->getItemName());

        if ($existingLineItem) {
            $this->recordThat(
                new ItemQuantityUpdated(
                    $this->aggregateRootId->toString(),
                    $lineItem->getItemName(),
                    $lineItem->getQuantity() + $existingLineItem->getQuantity()
                )
            );

            return $this;
        }

        $this->recordThat(
            new ItemAddedToCart($this->aggregateRootId->toString(), $lineItem)
        );

        return $this;
    }

    protected function applyShoppingCartWasInitialised(ShoppingCartWasInitialised $event): void
    {
        //do stuff
    }

    protected function applyItemAddedToCart(ItemAddedToCart $itemAddedToCart): void
    {
        $this->lineItems[] = $itemAddedToCart->getLineItem();
    }

    protected function applyItemQuantityUpdated(ItemQuantityUpdated $itemQuantityUpdated): void
    {
        /**
         * @var LineItem $lineItem
         */
        foreach ($this->lineItems as $key => $lineItem) {
            if ($lineItem->getItemName() == $itemQuantityUpdated->getItemName()) {
                $lineItem->updateQuantity($itemQuantityUpdated->getQuantity());
                $this->lineItems[$key] = $lineItem;
            }
        }
    }

    private function getItemFromCart(string $itemName): ?LineItem
    {
        /**
         * @var LineItem $lineItem
         */
        foreach ($this->lineItems as $lineItem) {
            if ($lineItem->getItemName() == $itemName) {
                return $lineItem;
            }
        }

        return null;
    }
}
