<?php


namespace App\Repositories;


use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepositoryInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @var Article
     */
    private $article;

    /**
     * ArticleRepository constructor.
     *
     * @param Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * @param array $options
     * @return array
     */
    public function all(array $options = []): array
    {
        $query = $this->article->select('id', 'title', 'link', 'author', 'published_at')->with('tags:id,name');

        if (isset($options['order_by']['column']) && isset($options['order_by']['way']))
            $query->orderBy($options['order_by']['column'], $options['order_by']['way']);

        return $query->get()->toArray();
    }

    /**
     * @param array $data
     * @param array $tagIdsForAttach
     * @return array
     */
    public function store(array $data = [], array $tagIdsForAttach = []): array
    {
        $article = $this->article->create($data);

        $article->tags()->attach($tagIdsForAttach);

        return $article->toArray();
    }

    /**
     * @param array $wheres
     * @return bool
     */
    public function exists(array $wheres = []): bool
    {
        $query = $this->article;

        foreach ($wheres as $column => $value) {
            $query->where($column, $value);
        }

        return $query->exists();
    }

    public function truncate(): void
    {
        $this->article->truncate();
    }
}
