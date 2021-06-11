<?php

namespace App\Commands;

use App\Repositories\CommentRepository;
use Illuminate\Console\Command;

class CommentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:comments {endpoint} {--prefix=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch comments from wordpress API.';

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
    public function handle(CommentRepository $comments)
    {
        if ($this->option('prefix')) {
            $comments->setPrefix($this->option('prefix'));
        }

        $comments->setEndPoint('https://'.$this->argument('endpoint'));
        $comments->fetch();

        $this->info('Done! 🍓');
    }
}
