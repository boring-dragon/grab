<?php

namespace App\Repositories;

use App\Comment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use App\Tranformers\CommentTranformer;
use Exception;

class CommentRepository
{
    //API Prefix
    protected $API_PREFIX = "/wp-json/wp/v2/";

    // Comment prefix
    protected $PREFIX = "comments";


    //Pagination key
    const PER_PAGE = 100;

    // Conditional comment keys
    protected $comment_keys = [
        'id',
        'post',
        'author_name',
        'comment',
        'upvotes',
        'downvotes',
        'date',
        'timestamp'
    ];
    protected $endpoint;

    /**
     * setEndPoint
     * 
     *  Sets the endpoint
     *
     * @param  mixed $endpoint
     * @return void
     */
    public function setEndPoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    /**
     * setPrefix
     * 
     *  Sets Prefix
     *
     * @param  mixed $prefix
     * @return void
     */
    public function setPrefix(string $prefix): void
    {
        $this->PREFIX = $prefix;
    }

    /**
     * fetch
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
                $response = Http::get($this->endpoint . $this->API_PREFIX . $this->PREFIX .  '?page=' . $page . '&per_page=' . $this::PER_PAGE);

                if (empty($response->json())) {
                    Log::info("All the comments added to the database");
                    $status = 1;
                }

                $collection = collect($response->json());

                Log::info("Page number " . $page);
                Log::info($count . " comments added to db");


                $page++;
                $collection->each(function ($comment, $key) use (&$count) {

                    $tranformedItem = CommentTranformer::tranform($comment);

                    Comment::create([
                        'source' => $this->ExtractDomain(),
                        'comment_id' => $tranformedItem["id"],
                        'post_id' => $tranformedItem["post"],
                        'author_name' => $tranformedItem["author_name"],
                        'comment' => strip_tags($tranformedItem["content"]["rendered"]),
                        'upvotes' => $tranformedItem["upvotes"],
                        'downvotes' => $tranformedItem["downvotes"],
                        'date' => $tranformedItem["timestamp"] ?: $tranformedItem["date"]
                    ]);

                    $count++;
                });
            } catch (Exception  $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
    }

    /**
     * ExtractDomain
     *
     * @return string
     */
    protected function ExtractDomain(): string
    {
        $parse = parse_url($this->endpoint);

        return $parse["host"];
    }

    /**
     * FormatLog
     *
     * @return void
     */
    protected function FormatLog(): void
    {
        Log::info("-------------------------");
        Log::info("Indexing Comments " . $this->ExtractDomain());
        Log::info("-------------------------");
    }
}
