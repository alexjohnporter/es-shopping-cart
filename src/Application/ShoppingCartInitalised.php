<?php

namespace App\Application;

class ShoppingCartInitalised
{
    public function __construct(private string $id) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return 'open';
    }
}