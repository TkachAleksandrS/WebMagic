<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'link',
        'author',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'date:d.m.Y'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @param array $options
     * @return array
     */
    public static function getAll($options = []): array
    {
        $query = Article::with('tags');

        if (isset($options['order_by']['column']) && isset($options['order_by']['way']))
            $query->orderBy($options['order_by']['column'], $options['order_by']['way']);

        return $query->get()->toArray();
    }

    /**
     * @param $data
     * @param $tagIdsForAttach
     */
    public static function store($data, $tagIdsForAttach)
    {
        $article = Article::create([
            'title' => $data['title'],
            'link' => $data['link'],
            'author' => $data['author'],
            'published_at' => $data['published_at'],
        ]);

        $article->tags()->attach($tagIdsForAttach);
    }
}
