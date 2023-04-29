<?php
declare(strict_types=1);

namespace App\UserInterface\Controller;

use App\Application\AddItemToCart;
use App\Application\ShoppingCartInitalised;
use App\Domain\ShoppingCart\LineItem;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    #[Route('/start', name: 'index')]
    public function index(): JsonResponse
    {
        $this->bus->dispatch(new ShoppingCartInitalised((string)Uuid::uuid4()));

        return new JsonResponse([
            'status' => 'ok'
        ]);
    }

    #[Route('/add-item/{cartId}', name: 'add-item')]
    public function addItemToCart(string $cartId)
    {
        $lineItemPayload = $this->getRandomFakeLineItem();
        $this->bus->dispatch(new AddItemToCart($cartId, LineItem::fromPayload($lineItemPayload)));

        return new JsonResponse([
            'status' => 'Item Added'
        ]);
    }

    private function getRandomFakeLineItem(): array
    {
        $items = $this->fakeLineItems();
        $count = count($items);

        return $items[rand(0, $count-1)];
    }

    private function fakeLineItems(): array
    {
        return [
            [
                'itemName' => 'Ceramic Mug',
                'price' => 250,
                'quantity' => 1
            ],
            [
                'itemName' => 'Ceramic Mug',
                'price' => 250,
                'quantity' => 2
            ],
            [
                'itemName' => 'Blue Plate',
                'price' => 300,
                'quantity' => 1
            ],
            [
                'itemName' => 'Silverware',
                'price' => 1000,
                'quantity' => 1
            ],
            [
                'itemName' => 'Pasta Bowl',
                'price' => 500,
                'quantity' => 1
            ],
            [
                'itemName' => 'Pasta Bowl',
                'price' => 500,
                'quantity' => 4
            ],
        ];
    }
}