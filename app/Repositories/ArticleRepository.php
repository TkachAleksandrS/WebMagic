<?php


namespace App\Repositories;


use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepositoryInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function all($options = [])
    {
        $query = Article::select('id', 'title', 'link', 'author', 'published_at')->with('tags:id,name');

        if (isset($options['order_by']['column']) && isset($options['order_by']['way']))
            $query->orderBy($options['order_by']['column'], $options['order_by']['way']);

        return $query->get()->toArray();
    }
}
