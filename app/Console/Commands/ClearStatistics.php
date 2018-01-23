<?php

namespace App\Console\Commands;

use App\WatchHistory;
use Illuminate\Console\Command;

class ClearStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear_statistics';

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
     * @return mixed
     */
    public function handle()
    {
        $this->$this->resetStatistics();
    }

    public function resetStatistics(){
        $stat = WatchHistory::all();
        foreach ($stat as $elem){
            $elem->delete();
        }
    }
}
