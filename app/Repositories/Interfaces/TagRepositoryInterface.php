<?php

namespace App\Repositories\Interfaces;

interface TagRepositoryInterface
{
    public function store(array $data): int;

    public function getIsSet(string $key, string $value): array;

    public function truncate(): void;
}
