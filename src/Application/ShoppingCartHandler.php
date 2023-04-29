<?php
declare(strict_types=1);

namespace App\Application;

use App\Domain\ShoppingCart\ShoppingCart;
use App\Domain\ShoppingCart\ShoppingCartRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class ShoppingCartHandler
{
    public function __construct(private ShoppingCartRepository $cartRepository) {}

    #[AsMessageHandler]
    public function handleShoppingCartInitialised(ShoppingCartInitalised $cartInitalised): void
    {
        $cart = ShoppingCart::initiate($cartInitalised->getId());
        $this->cartRepository->save($cart);
    }

    #[AsMessageHandler]
    public function handleAddItemToCart(AddItemToCart $addItemToCart): void
    {
        $cart = $this->cartRepository->get($addItemToCart->getCartId());
        $cart->addItem($addItemToCart->getLineItem());

        $this->cartRepository->save($cart);
    }
}