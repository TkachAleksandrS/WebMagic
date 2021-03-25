<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
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

    private $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

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

        $articles = $this->articleRepository->all($options);

        return view('home', compact('articles'));
    }

    /**
     * @return RedirectResponse
     */
    public function parse(): RedirectResponse
    {
        Artisan::call('parse refresh 0');

        return back();
    }
}
