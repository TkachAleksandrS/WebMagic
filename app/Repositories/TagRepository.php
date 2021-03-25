<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagRepository implements TagRepositoryInterface
{
    /**
     * @var Tag
     */
    private $tag;

    /**
     * TagRepository constructor.
     *
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @param array $data
     * @return int
     */
    public function store(array $data): int
    {
        return $this->tag->insertGetId($data);
    }

    /**
     * @param string $key
     * @param string $value
     * @return array
     */
    public function getIsSet(string $key, string $value): array
    {
        return $this->tag->pluck($value, $key)->toArray();
    }

    /**
     *
     */
    public function truncate(): void
    {
        $this->tag->truncate();
    }
}
