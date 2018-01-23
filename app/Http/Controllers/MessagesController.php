<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function getMess(Request $request)
    {
        $tu_id = $request->fid;
        return Message::where([['from_id', Auth::id()], ['to_id', $tu_id]])->orWhere([['from_id', $tu_id], ['to_id', Auth::id()]])->orderBy('id')->get();
    }

    public function setMess(Request $request)
    {

        $this->validate($request, array(
            'u_mess' => 'required',
            'u_to_id' => 'required|integer'
        ));

        $u_mess = $request->u_mess;

        $u_to_id = $request->u_to_id;

        $messages = new Message;

        $messages->from_id = Auth::id();

        $messages->to_id = $u_to_id;

        $messages->mess = $u_mess;

        $messages->save();

    }
}
