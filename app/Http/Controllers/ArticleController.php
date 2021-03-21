<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Support\Facades\Artisan;

class ArticleController extends Controller
{
    private $defaultOptions = [
        'order_by' => ['column' => 'author', 'way' => 'asc']
    ];

    public function index(ArticleRequest $request) {

        $options = [
            'order_by' => [
                'column' => $request->get('column') ?? $this->defaultOptions['order_by']['column'],
                'way' => $request->get('way') ?? $this->defaultOptions['order_by']['way']
            ]
        ];

        return view('home', [
            'articles' => Article::getAll($options)
        ]);
    }

    public function parse() {

        Artisan::call('parse refresh');

        return view('home', [
            'articles' => Article::getAll($this->defaultOptions)
        ]);
    }
}
