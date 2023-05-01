<?php

namespace App\Infra\ServiceFactory;

use App\Domain\ShoppingCart\ShoppingCart;
use App\Domain\ShoppingCart\ShoppingCartRepository;
use Doctrine\DBAL\DriverManager;
use EventSauce\EventSourcing\EventSourcedAggregateRootRepository;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\MessageRepository\DoctrineMessageRepository\DoctrineUuidV4MessageRepository;

class ShoppingCartRepositoryFactory
{
    public function create(): ShoppingCartRepository
    {
        //quick and dirty to get it working
        $connection = DriverManager::getConnection(
            ['url' => 'mysql://symfony:symfony@database/symfony', 'driver' => 'pdo_mysql']);

        return new ShoppingCartRepositoryEventSauce(
            new EventSourcedAggregateRootRepository(
                ShoppingCart::class,
                new DoctrineUuidV4MessageRepository(
                    $connection,
                    'event_store',
                    new ConstructingMessageSerializer(),
                )
            )
        );
    }
}