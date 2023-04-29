<?php

namespace App\Application;

use App\Domain\ShoppingCart\LineItem;

class AddItemToCart
{
    public function __construct(
        private string $cartId,
        private LineItem $lineItem
    ) {}

    public function getCartId(): string
    {
        return $this->cartId;
    }

    public function getLineItem(): LineItem
    {
        return $this->lineItem;
    }
}
