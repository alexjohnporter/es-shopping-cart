<?php
declare(strict_types=1);

namespace App\Infra\Read;

use App\Domain\ShoppingCart\Events\ItemAddedToCart;
use App\Domain\ShoppingCart\Events\ShoppingCartWasInitialised;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageConsumer;

class CartProjector implements MessageConsumer
{

    //ew - just doing it quick for the spike
    public function __construct(private Connection | null $connection = null)
    {
        $this->connection = DriverManager::getConnection(
            ['url' => 'mysql://symfony:symfony@database/symfony', 'driver' => 'pdo_mysql']);
    }

    public function handle(Message $message): void
    {
        $event = $message->payload();

        //could use strategy pattern here to handle various events
        if ($event instanceof ShoppingCartWasInitialised) {
            $this->connection->insert('read_model_cart', [
                'cart_id' => $event->getShoppingCartId()->toString(),
                'created_at' => $event->getCreatedAt()->format('Y/m/d H:i:s'),
                'status' => $event->getStatus()
            ]);
        }

        if ($event instanceof ItemAddedToCart) {
            $this->connection->insert('read_model_cart_item', [
                'cart_id' => $event->getShoppingCartId(),
                'item_name' => $event->getLineItem()->getItemName(),
                'price' => $event->getLineItem()->getPrice(),
                'created_at' => (new \DateTimeImmutable('now'))->format('Y/m/d H:i:s'),
            ]);
        }
    }
}