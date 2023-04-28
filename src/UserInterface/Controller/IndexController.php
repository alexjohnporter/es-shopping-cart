<?php
declare(strict_types=1);

namespace App\UserInterface\Controller;

use App\Application\ShoppingCartInitalised;
use App\Domain\ShoppingCart\ShoppingCartId;
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

    #[Route('/', name: 'index')]
    public function index(): JsonResponse
    {
        $this->bus->dispatch(new ShoppingCartInitalised((string)Uuid::uuid4()));

        return new JsonResponse([
            'status' => 'ok'
        ]);
    }
}