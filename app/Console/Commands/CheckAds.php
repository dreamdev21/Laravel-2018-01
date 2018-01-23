<?php

namespace App\Console\Commands;

use App\Advertising;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CheckAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_ads';

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
        //
    }

    public static function check_ads(){
        $tv_users = User::where('role',4)->get(['id']);
        foreach ($tv_users as $user){
            $ads = Advertising::where('user_id', $user->id)->get();
            self::process_ads($ads);
        }
    }

    public static function process_ads($ads){
        foreach ($ads as $adv){
            $now = Carbon::now();
            $exp_date = Carbon::parse($adv->expiration_date);
            if($now->gt($exp_date)){
                $del_img_path = '/ads/images/'.$adv->preroll_thumbimg;
                if(Storage::disk('s3frenvid')->exists($del_img_path)) {
                    Storage::disk('s3frenvid')->delete($del_img_path);
                }
                $del_video_path = '/ads/videos/'.$adv->preroll_mp4;
                if(Storage::disk('s3frenvid')->exists($del_video_path)) {
                    Storage::disk('s3frenvid')->delete($del_video_path);
                }
                $adv->delete();
            }
        }
    }
}
