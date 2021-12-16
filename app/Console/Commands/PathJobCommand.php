<?php

namespace App\Console\Commands;

use App\Jobs\PathJob;
use App\Models\Files;
use App\Models\User;
use Illuminate\Console\Command;

class PathJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'path:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // PathJob::dispatch(Files::inRandomOrder()->get()->toArray());
        print_r($this->data);

        echo 'Even has been Handled';

    }
}
