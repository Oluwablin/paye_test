<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch_articles {--limit=5} {--has_comments_only}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch articles from external url';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $limit = $this->option('limit');
            $hasCommentsOnly = $this->option('has_comments_only');
            $url = env('ARTICLES_BASE_URL');

            $response = Http::get($url, [
                'per_page' => $limit
            ]);

            if ($response->successful()) {
                $articles = $response->json();

                if ($hasCommentsOnly) {
                    $articles = array_filter($articles, function ($article) {
                        return $article['comments_count'] > 0;
                    });
                }

                $headers = ['Title', 'Readable Publish Date', 'Comments Count', 'Username'];
                $data = array_map(function ($article) {
                    return [
                        $article['title'],
                        $article['readable_publish_date'],
                        $article['comments_count'],
                        $article['user']['username']
                    ];
                }, $articles);

                $this->table($headers, $data);
                $this->info('Successful fetching of articles from external url.');
            } else {
                $this->error('Failed to fetch articles from external url');
            }
        } catch (\Exception $exception) {
            dump($exception->getMessage());
            Log::info('FAILED FETCHING OF ARTICLES EXCEPTION ' . $exception->getMessage());
        }
    }
}
