<?php

namespace App\Repositories;

use App\Post;
use App\Tranformers\PostTranformer;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PostRepository
{
    //API Prefix
    protected $API_PREFIX = '/wp-json/wp/v2/';

    // Post prefix
    protected $PREFIX = 'posts';

    //Pagination key
    const PER_PAGE = 100;

    protected $endpoint;

    /**
     * setEndPoint.
     *
     *  Sets the endpoint
     *
     * @param mixed $endpoint
     *
     * @return void
     */
    public function setEndPoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    /**
     * setPrefix.
     *
     *  Sets Prefix
     *
     * @param mixed $prefix
     *
     * @return void
     */
    public function setPrefix(string $prefix): void
    {
        $this->PREFIX = $prefix;
    }

    /**
     * fetch.
     *
     *  Fetch the data from the API
     *
     * @return void
     */
    public function fetch(): void
    {
        $status = 0;
        $page = 1;
        $count = 0;

        $this->FormatLog();

        while ($status == 0) {
            try {
                $response = Http::get($this->endpoint.$this->API_PREFIX.$this->PREFIX.'?page='.$page.'&per_page='.$this::PER_PAGE);

                if (empty($response->json())) {
                    Log::info('All the Posts added to the database');
                    $status = 1;
                }

                if (Arr::get($response->json(), 'data.status') === 400) {
                    Log::error('An error occured');
                    break;
                }

                $collection = collect($response->json());

                $collection->each(function ($post, $key) use (&$count) {
                    $tranformedItem = PostTranformer::tranform($post);

                    Post::create([
                        'source'  => $this->ExtractDomain(),
                        'post_id' => $tranformedItem['id'],
                        'date'    => $tranformedItem['date'],
                        'title'   => strip_tags($tranformedItem['title']['rendered']),
                        'content' => strip_tags($tranformedItem['content']['rendered']),
                        'link'    => $tranformedItem['link'],
                    ]);

                    $count++;
                });

                Log::info('Page number '.$page);
                Log::info($count.' Posts added to db');

                $page++;
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
    }

    /**
     * ExtractDomain.
     *
     * @return string
     */
    protected function ExtractDomain(): string
    {
        $parse = parse_url($this->endpoint);

        return $parse['host'];
    }

    /**
     * FormatLog.
     *
     * @return void
     */
    protected function FormatLog(): void
    {
        Log::info('-------------------------');
        Log::info('Indexing Posts '.$this->ExtractDomain());
        Log::info('-------------------------');
    }
}
