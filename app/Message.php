<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Message extends Model
{

    protected $fillable = [
        'from_id', 'to_id', 'mess'
    ];

    protected $table = 'messages';

    public function chat_r()
    {
        return $this::where('from_id', Auth::id())->where('to_id', Auth::id())->get();
    }


}
