<?php

namespace App\Commands;

use App\Repositories\PostRepository;
use Illuminate\Console\Command;

class PostCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:posts {endpoint} {--prefix=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch posts from wordpress API.';

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
     * @return mixed
     */
    public function handle(PostRepository $posts)
    {
        if ($this->option('prefix')) {
            $posts->setPrefix($this->option('prefix'));
        }

        $posts->setEndPoint('https://'.$this->argument('endpoint'));
        $posts->fetch();

        $this->info('Done! 🍓');
    }
}
