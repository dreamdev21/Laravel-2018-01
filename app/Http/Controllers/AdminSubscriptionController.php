<?php

namespace App\Http\Controllers;

use App\SubscriptionPlan;
use Illuminate\Http\Request;

class AdminSubscriptionController extends Controller
{
    public function update(Request $request){
        $subscription = SubscriptionPlan::find($request->input('id'));
        $subscription->name = $request->input('name');
        $subscription->amount = floatval($request->input('amount'))*100;
        $subscription->save();
        return redirect()->back();
    }

    public function index(){
        $basic = SubscriptionPlan::find(1);
        $basic->amount = $basic->amount/100;
        $pro = SubscriptionPlan::find(2);
        $pro->amount = $pro->amount/100;
        return view('admin.subscriptions.index', compact('basic', 'pro'));
    }

    public function edit($id){
        $subscription = SubscriptionPlan::find($id);
        return view('admin.subscriptions.edit', compact('subscription'));
    }
}
