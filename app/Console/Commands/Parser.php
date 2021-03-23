<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Tag;
use App\Traits\Sort;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;
use Throwable;


class Parser extends Command
{
    use Sort;

    /**
     * Parsing link.
     *
     * @var string
     */
    private $link;

    /**
     * Parsing domain.
     *
     * @var string
     */
    private $domain;

    /**
     * The date until which we receive articles.
     *
     * @var numeric
     */
    private $timestampDateExpired;

    /**
     * @var numeric
     */
    private $currentTime;

    /**
     * Init Log with channel
     *
     * @var $parseLog
     */
    private $parseLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse {type=add}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse articles from env(PARSE_DOMAIN). parse [add/refresh] ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $carbon = Carbon::now();
        $this->currentTime = $carbon->toDateTimeString();
        $this->timestampDateExpired = $carbon->subMonths(env('PARSE_MONTHS', 4))->timestamp;

        $this->domain = env('PARSE_DOMAIN', 'https://laravel-news.com');
        $this->link = $this->domain . '/blog';

        $this->parseLog = Log::channel('parser');

        parent::__construct();
    }

    public function handle(): void
    {
        DB::transaction(function() {

            $this->parseLog->info('Parsing started [' . $this->argument('type') . ']');

            if ($this->argument('type') === 'refresh')
                $this->clearDB();

            $articles = $this->getArticles();

            $this->storeArticles($articles);
        });
    }

    /**
     * Get list data for articles
     *
     * @param int $page
     * @param array $foundArticles
     * @return array
     * @throws \Exception
     */
    private function getArticles(int $page = 1, array &$foundArticles = []): array
    {
        // Get list links articles how object|Crawler
        $blogItems = $this->getBlogItems($page);

        // Get all data about article.
        $data = $this->getData($blogItems);

        if ($page === 1)
            // Sort array because general news had random date
            $foundArticles = $this->sortArrByKey($data['res'], 'published_at');
        else
            // Supplement articles
            $foundArticles = array_merge($foundArticles, $data['res']);

        // Get next page with list articles
        if ($data['isGetMore'])
            $this->getArticles(++$page, $foundArticles);

        return $foundArticles;
    }

    /**
     * Get list links articles how object|Crawler.
     *
     * @param int $page
     * @return object|Crawler
     * @throws \Exception
     */
    private function getBlogItems(int $page)
    {
        if ($page > 1) {
            // Skip general news - repeat on every page
            $xpath = '// li[contains(@class, "group-link-underlin")][position()>1]';
            $path = $this->link . '?page=' . $page;
        } else {
            // For first page get articles with general article
            $xpath = '// li[contains(@class, "group-link-underlin")]';
            $path = $this->link;
        }

        // Init crawler
        try {
            $crawler = new Crawler(file_get_contents($path));
        } catch (\Exception $e) {
            $this->parseLog->error('file_get_contents');
            throw $e;
        }

        return $crawler->filterXPath($xpath);
    }

    /**
     * Get all data about article.
     *
     * @param $items
     * @return array
     * @throws \Exception
     */
    private function getData($items): array
    {
        $res = [];
        $isGetMore = true;

        // Check each object|Crawler if article have tag === news, open link and get details
        foreach($items as $index => $item) {
            $crawler = new Crawler($item);

            $tag = $this->crawlerText($crawler, '// span', 'tag');

            if (strtolower($tag) !== 'news') continue;

            $dateCarbon = Carbon::parse(
                $this->crawlerText($crawler, '// p', 'date')
            );

            // Check date publication article
            if ($dateCarbon->timestamp <= $this->timestampDateExpired) {
                $isGetMore = false;
                break;

            } else {
                try {
                    $link = $crawler->filterXPath('// a')->attr('href');
                } catch (\Exception $e) {
                    $this->parseLog->error('link');
                    throw $e;
                }

                $isArticleDuplicate = Article::whereLink($link)->exists();

                if ($isArticleDuplicate) continue;

                $publishedAt = $dateCarbon->timestamp;
                $details = $this->getDetails($link);

                $res[] = $details + [
                    'published_at' => $publishedAt,
                    'link' => $link
                ];
            }
        }

        return compact('res', 'isGetMore');
    }

    /**
     * Get details about article title, author, tags.
     *
     * @param string $link
     * @return array
     * @throws \Exception
     */
    private function getDetails(string $link): array
    {
        $path = $this->domain . $link;

        $crawler = new Crawler(file_get_contents($path));

        $title = $this->crawlerText($crawler, '// h1', 'title');

        $author = $this->crawlerText($crawler, '// article // p[contains(@itemprop, "author")] // a', 'author');

        try {
            $tags = $crawler->filterXPath('// article // a[contains(@class, "transition-opacity")]')
                ->each(function (Crawler $node) {
                    return $node->text();
                });
        } catch (\Exception $e) {
            $this->parseLog->error('tags: ' . $e);
            throw $e;
        }

        return compact('title', 'author', 'tags');
    }

    /**
     * Store articles in DB.
     *
     * @param array $articles
     * @return array
     */
    private function storeArticles(array $articles): void
    {
        $issetTags = Tag::pluck('id', 'name')->toArray();

        foreach ($articles as $index => $article) {
            $tagIdsForAttach = [];

            foreach ($article['tags'] as $tag) {
                $tagName = strtolower($tag);

                if (isset($issetTags[$tagName])) {
                    $tagIdsForAttach[] = $issetTags[$tagName];
                } else {
                    $tagId = Tag::insertGetId(['name' => $tagName]);
                    $tagIdsForAttach[] = $tagId;
                    $issetTags += [$tagName => $tagId];
                }
            }

            $data = [
                'title' => $article['title'],
                'link' => $article['link'],
                'author' => $article['author'],
                'published_at' => Carbon::parse($article['published_at'])->toDateString()
            ];

            Article::store($data, $tagIdsForAttach);

            $this->parseLog->info(
                'Stored article: ' . $article['link'] . '. Tags: ['.implode(',', $article['tags']).'].'
            );
        }

        $this->parseLog->info('Stored ' . count($articles) . ' new articles.');
    }

    /**
     * @param Crawler $crawler
     * @param string $xpath
     * @param string $dataName
     * @return string
     * @throws \Exception
     */
    private function crawlerText(Crawler $crawler, string $xpath, string $dataName = ''): string
    {
        try {
            return $crawler->filterXPath($xpath)->text();
        } catch (\Exception $e) {
            $this->parseLog->error($dataName);
            throw $e;
        }
    }

    /**
     * Clear DB after parse
     */
    private function clearDB()
    {
        DB::statement("SET foreign_key_checks=0");

        DB::table('article_tag')->truncate();
        Article::truncate();
        Tag::truncate();

        DB::statement("SET foreign_key_checks=1");
    }
}
