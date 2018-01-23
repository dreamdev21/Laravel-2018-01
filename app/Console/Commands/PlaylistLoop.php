<?php

namespace App\Console\Commands;

use App\Channel;
use App\Videos;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PlaylistLoop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'playlist_loop';

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
        self::loopPlaylist();
    }

    public static function loopPlaylist(){
        $channels = Channel::all();
        foreach($channels as $ch){
            if($ch->is_loop){
                $videos = Videos::where('channel_id', $ch->id)->get()->toArray();
                $time = Videos::where('channel_id', $ch->id)->get(['end_time'])->toArray();
                if(max($time)){
                    $max_time = max($time)['end_time'];
                    foreach ($videos as $video){
                        if($video['end_time'] === $max_time) {
                            if(self::checkTime($max_time)){
                                self::updateTimes($videos);
                            }
                        };
                    }
                }
            }
        }
    }

    public static function checkTime($end_time){
        $now = Carbon::now();
        $end_time = Carbon::parse($end_time);
        if($now->lt($end_time)) return false;
        elseif ($now->eq($end_time)) return true;
        elseif ($now->gt($end_time) && $now->lt($end_time->addMinutes(1))){
            return true;
        }
        else return false;
    }

    public static function updateTimes($videos){
        foreach ($videos as $video){
            $video = Videos::find($video['id']);
            $start = Carbon::parse($video['start_time']);
            $end = Carbon::parse($video['end_time']);
            $diff = $end->diffInMinutes($start);
            $video->start_time = Carbon::now();
            $video->end_time = Carbon::now()->addMinutes($diff);
            $video->save();
        }
    }
}
