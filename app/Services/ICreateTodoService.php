<?php

namespace App\Services;

interface ICreateTodoService
{
    public function resolve(string $strategy): array;

    public function execute(): array;
}
