<?php

namespace App\Repositories\Interfaces;

interface ArticleRepositoryInterface
{
    public function all(array $options): array;

    public function store(array $data, array $tagIdsForAttach): array;

    public function truncate(): void;

    public function exists(array $wheres): bool;
}
