<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Studio;
use Illuminate\Support\Facades\Auth;
use App\Movie;
use App\Payment;
use Carbon\Carbon;


class StudioDashboardController extends Controller
{
    public function index()
    {

        $yesterday = Carbon::now()->subDays(0)->toDateTimeString();
        $one_week_ago = Carbon::now()->subWeeks(1)->toDateTimeString();
        $one_monht_ago = Carbon::now()->subMonth(1)->toDateTimeString();

        $movie = Movie::where('studio_id', Auth::user()->studio_id)->get();

        $studio = Studio::where('id', Auth::user()->studio_id)->first();

        $weekly_movie_count = 0;
        $mountly_movie_count = 0;
        $total_movie_sales_count = 0;
        $total_movie_count = 0;
        $total_movie_amount = 0;

        $calcresweek = 0;
        $calcresmonth = 0;
        $calcrestotal = 0;
        $monthly_sales = [];
        foreach ($movie as $val){
            $total_movie_count++;
            $total_movie_amount = $total_movie_amount + $val->price;

            $calcpay = Payment::where('created_at', '>=', $one_week_ago)->where('created_at', '<=', $yesterday)->where('movie_id', $val->id)->orwhere('season_id', $val->season_id)->orwhere('series_id', $val->series_id)->get();
            foreach ($calcpay as $cp){
                $weekly_movie_count++;
                $calcresweek = $calcresweek + $cp->amount;
            }


            $calcpaymonth = Payment::where('created_at', '<=', $yesterday)->where('created_at', '>=', $one_monht_ago)->where('movie_id', $val->id)->orwhere('season_id', $val->season_id)->orwhere('series_id', $val->series_id)->get();

            foreach ($calcpaymonth as $cp){
                $th_date = substr($cp->created_at, 0, 10);
                if(isset($monthly_sales[$th_date])){
                    $monthly_sales[$th_date] = $monthly_sales[$th_date] + $cp->amount;
                }
                else{
                    $monthly_sales[$th_date] = $cp->amount;
                }
                $mountly_movie_count++;
                $calcresmonth = $calcresmonth + $cp->amount;
            }


            $calcpaytotal = Payment::where('movie_id', $val->id)->orwhere('season_id', $val->season_id)->orwhere('series_id', $val->series_id)->get();
            foreach ($calcpaytotal as $cp){
                $total_movie_sales_count++;
                $calcrestotal = $calcrestotal + $cp->amount;
            }


        }

        if($total_movie_amount){
            $total_movie_amount = $total_movie_amount / $total_movie_count;
            $total_movie_amount = round($total_movie_amount, 2);
        }

        $calcresweek  = $calcresweek  / 100 * $studio->percent;
        $calcresmonth = $calcresmonth / 100 * $studio->percent;
        $calcrestotal = $calcrestotal / 100 * $studio->percent;

        $calcresweek = round($calcresweek);
        $calcresmonth = round($calcresmonth);
        $calcrestotal = round($calcrestotal);
        $dmctrue = true;

        return view('admin.users.studioDashboard', compact('calcresweek', 'calcresmonth', 'weekly_movie_count', 'mountly_movie_count', 'total_movie_sales_count', 'calcrestotal', 'total_movie_count', 'total_movie_amount', 'monthly_sales', 'dmctrue'));
    }

    public function getChartRes(Request $request)
    {
        $date_dp = $request->date_dp;

        $m1 =  Carbon::createFromFormat('Y-m-d H:i:s', $date_dp.' 00:00:00', 'UTC')->toDateTimeString();
        $m2 = Carbon::createFromFormat('Y-m-d H:i:s', $date_dp.' 00:00:00', 'UTC')->addMonth(1)->toDateTimeString();

        $movie = Movie::where('studio_id', Auth::user()->studio_id)->get();

        $mountly_movie_count = 0;
        $total_movie_count = 0;
        $total_movie_amount = 0;

        $calcresmonth = 0;
        $monthly_sales = [];
        foreach ($movie as $val){
            $total_movie_count++;
            $total_movie_amount = $total_movie_amount + $val->price;

            $calcpaymonth_m = Payment::where('created_at', '<=', $m2)->where('created_at', '>=', $m1)->where('movie_id', $val->id)->get();
            $calcpaymonth_seas = Payment::where('created_at', '<=', $m2)->where('created_at', '>=', $m1)->where('season_id', $val->season_id)->get();
            $calcpaymonth_ser = Payment::where('created_at', '<=', $m2)->where('created_at', '>=', $m1)->where('series_id', $val->series_id)->get();

            foreach ($calcpaymonth_m as $cpm){
                $th_datem = substr($cpm->created_at, 0, 10);
                if(isset($monthly_sales[$th_datem])){
                    $monthly_sales[$th_datem] = $monthly_sales[$th_datem] + $cpm->amount;
                }
                else{
                    $monthly_sales[$th_datem] = $cpm->amount;
                }
                $mountly_movie_count++;
                $calcresmonth = $calcresmonth + $cpm->amount;
            }

             foreach ($calcpaymonth_seas as $cpse){
                $th_datese = substr($cpse->created_at, 0, 10);

                if(isset($monthly_sales[$th_datese])){
                    $monthly_sales[$th_datese] = $monthly_sales[$th_datese] + $cpse->amount;
                }
                else{
                    $monthly_sales[$th_datese] = $cpse->amount;
                }
                $mountly_movie_count++;
                $calcresmonth = $calcresmonth + $cpse->amount;
            }

             foreach ($calcpaymonth_ser as $cpsr){
                $th_datesr = substr($cpsr->created_at, 0, 10);

                if(isset($monthly_sales[$th_datesr])){
                    $monthly_sales[$th_datesr] = $monthly_sales[$th_datesr] + $cpsr->amount;
                }
                else{
                    $monthly_sales[$th_datesr] = $cpsr->amount;
                }
                $mountly_movie_count++;
                $calcresmonth = $calcresmonth + $cpsr->amount;
            }

        }

        echo json_encode($monthly_sales);
        exit;

    }

}