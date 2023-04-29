<?php
declare(strict_types=1);

namespace App\Infra;

use App\Domain\ShoppingCart\Exceptions\ShoppingCartNotFound;
use App\Domain\ShoppingCart\ShoppingCart;
use App\Domain\ShoppingCart\ShoppingCartId;
use App\Domain\ShoppingCart\ShoppingCartRepository;
use EventSauce\EventSourcing\AggregateRootRepository;

class ShoppingCartRepositoryEventSauce implements ShoppingCartRepository
{
    public function __construct(private AggregateRootRepository $repository) {}
    public function save(ShoppingCart $cart): void
    {
        $this->repository->persist($cart);
    }

    public function get(string $cartId): ShoppingCart
    {
        $cart = $this->repository->retrieve(ShoppingCartId::fromString($cartId));

        if (!$cart instanceof ShoppingCart) {
            throw new ShoppingCartNotFound();
        }

        return $cart;
    }
}