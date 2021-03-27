<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;

class ArticleController extends Controller
{
    private $defaultOptions = [
        'order_by' => ['column' => 'author', 'way' => 'asc'],
    ];

    private $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param ArticleRequest $request
     * @return JsonResponse
     */
    public function index(ArticleRequest $request): JsonResponse
    {
        $options = [
            'order_by' => [
                'column' => $request->get('column', $this->defaultOptions['order_by']['column']),
                'way' => $request->get('way', $this->defaultOptions['order_by']['way']),
            ],
        ];

        $articles = $this->articleRepository->all($options);

        return response()->json($articles);
    }

    /**
     * @return JsonResponse
     */
    public function parse(): JsonResponse
    {
        Artisan::call('parse refresh 0');

        $articles = $this->articleRepository->all($this->defaultOptions);

        return response()->json($articles);
    }
}
