<?php

namespace App\Providers;

use App\Repositories\ArticleRepository;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\TagRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    public $bindings = [
        ArticleRepositoryInterface::class => ArticleRepository::class,
        TagRepositoryInterface::class => TagRepository::class,
    ];
}
