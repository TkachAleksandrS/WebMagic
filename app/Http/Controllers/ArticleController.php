<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;

class ArticleController extends Controller
{
    private $defaultOptions = [
        'order_by' => ['column' => 'author', 'way' => 'asc']
    ];

    /**
     * @param ArticleRequest $request
     * @return Application|Factory|View
     */
    public function index(ArticleRequest $request)
    {
        $options = [
            'order_by' => [
                'column' => $request->get('column', $this->defaultOptions['order_by']['column']),
                'way' => $request->get('way', $this->defaultOptions['order_by']['way'])
            ]
        ];

        return view('home', [
            'articles' => Article::getAll($options)
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function parse(): RedirectResponse
    {
        Artisan::call('parse refresh');

        return back();
    }
}
