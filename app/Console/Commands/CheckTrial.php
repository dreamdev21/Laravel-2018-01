<?php

namespace App\Console\Commands;

use App\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckTrial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_trial';

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
        $this->checkTrials();
    }

    public function checkTrials(){
        $users = User::where([['trial_used',1],['role',4]])->get();
        foreach ($users as $user){
            $subscription = Subscription::where('user_id', $user->id)->orderBy('id','desc')->first();
            if(!empty($subscription) && ($subscription->subscription_type === 'trial')){
                $now = Carbon::now();
                $expire = Carbon::parse($subscription->payment_date)->addWeek();
                if($now->gt($expire)){
                    $user->subscription_enabled = false;
                    $user->save();
                }
            }
        }
    }
}
