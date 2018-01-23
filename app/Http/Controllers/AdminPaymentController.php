<?php

namespace App\Http\Controllers;

use App\PaymentRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Advertising;
use App\Videos;
use App\Channel;
use JmesPath\Env;
use Session;
use File;
use App\BannerAdvertising;

class AdminPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payreq = PaymentRequest::get();
        if($payreq == null){
            $payreq = false;
        }
        return view('admin.payment.index', compact('payreq'));
    }

    public function subStatStudio(Request $request)
    {
        $payid = $request->payreqid;
        $val = $request->value;
        $res = PaymentRequest::where('id', $payid)->first();
        $res->status = $val;
        $res->save();
        echo 1;
        exit;
    }


}
