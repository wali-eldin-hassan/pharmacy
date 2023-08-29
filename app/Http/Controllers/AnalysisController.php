<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
    public function index()
    {
        return view('analysis.index');
    }

    public function sales()
    {
        $week = DB::table('sales')
            ->selectRaw('SUM(sales.price * ( 100.0 - products.p_discount ) / 100.0)  as price, DAYNAME(sales.created_at) as day')
            ->join('products', 'products.p_id', '=', 'sales.product_id')
            ->whereRaw('sales.created_at > DATE_SUB(CURDATE(), INTERVAL 1 WEEK) GROUP BY (day)')
            ->get();

        $day = DB::table('sales')
            ->selectRaw(' SUM(sales.price * ( 100.0 - products.p_discount ) / 100.0) AS price, DAYNAME(sales.created_at) AS day')
            ->join('products', 'products.p_id', '=', 'sales.product_id')
            ->whereRaw('DATE(sales.created_at) = DATE(NOW() - INTERVAL 1 DAY) OR DATE(sales.created_at) =  DATE(NOW())')
            ->groupBy('day')
            ->orderBy('sales.created_at')
            ->get();
        $month = DB::table('sales')
            ->select(DB::raw('SUM(sales.price) as price, MONTHNAME(sales.created_at) as month '))
            ->groupBy(DB::raw('DATE_FORMAT(sales.created_at, "%m")'))
            ->get();

        $topDrugsDay = DB::table('sales')
            ->select(DB::raw(' COUNT(*) as total, products.p_gname as price'))
            ->join('products', 'products.p_id', '=', 'sales.product_id')
            ->whereRaw(' sales.created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY)')
            ->groupBy(DB::raw('products.p_gname LIMIT 10'))
            ->get();
        $topDrugsWeek = DB::table('sales')
            ->select(DB::raw(' COUNT(*) as total, products.p_gname as price'))
            ->join('products', 'products.p_id', '=', 'sales.product_id')
            ->whereRaw('sales.created_at >= DATE_SUB(NOW(),INTERVAL 1 WEEK)')
            ->groupBy(DB::raw('products.p_gname LIMIT 10'))
            ->get();
        $topDrugsMonth = DB::table('sales')
            ->select(DB::raw(' COUNT(*) as total, products.p_gname as price'))
            ->join('products', 'products.p_id', '=', 'sales.product_id')
            ->whereRaw('sales.created_at >= DATE_SUB(NOW(),INTERVAL 1 MONTH)')
            ->groupBy(DB::raw('products.p_gname LIMIT 10'))
            ->get();
        $topDrugsYear = DB::table('sales')
            ->select(DB::raw('COUNT(*) as total, products.p_gname as price'))
            ->join('products', 'products.p_id', '=', 'sales.product_id')
            ->whereRaw('sales.created_at >= DATE_SUB(NOW(),INTERVAL 1 YEAR)')
            ->groupBy(DB::raw('products.p_gname LIMIT 10'))
            ->get();

        //day if today = null or yasterday = null return
        if (!isset($day[0]->price) && !isset($day[1]->price)) {
            $day = array('yasterday' => '0', 'today' => '0');
        } elseif (!isset($day[1]->price)) {
            $day = array('yasterday' => $day[0]->price, 'today' => '0');
        } elseif (!isset($day[0]->price)) {
            $day = array('yasterday' => '0', 'today' => $day[1]->price);
        } else {
            $day = array('yasterday' => $day[0]->price, 'today' => $day[1]->price);
        }

        return view('analysis.sales', ['week' => $week, 'day' => $day, 'month' => $month, 'topDrugsDay' => $topDrugsDay, 'topDrugsWeek' => $topDrugsWeek, 'topDrugsMonth' => $topDrugsMonth, 'topDrugsYear' => $topDrugsYear]);
    }


    public function purchases()
    {
        $year = DB::table('products')
            ->select(DB::raw('SUM(p_imprice) as price, MONTHNAME(created_at) as month'))
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%m")'))
            ->get();

        $topQuantity = DB::table('products')
            ->select(DB::raw('SUM(p_quantity) AS quantity, p_gname AS name'))
            ->groupBy('p_quantity')
            ->orderBy('p_quantity', 'desc')
            ->limit(10)
            ->get();
        $lastDrugs = DB::table('products')
            ->select(DB::raw('p_quantity AS quantity, p_gname AS name'))
            ->orderBy('p_quantity', 'DESC')
            ->limit(10)
            ->get();

        return view('analysis.purchases', ['year' => $year, 'topQuantity' => $topQuantity, 'lastDrugs' => $lastDrugs]);
    }

    public function customers()
    {
        $week = DB::table('customers')
            ->selectRaw('count(id) AS number, DAYNAME(created_at) as day')
            ->whereRaw('created_at >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND created_at < curdate() GROUP BY (day)')
            ->get();
        $year = DB::table('customers')
            ->selectRaw('count(id) AS number, MONTHNAME(created_at) as month')
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%m")'))
            ->get();
        $lastCustomers = DB::table('customers')
            ->select(DB::raw('number,name'))
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->get();
        return view('analysis.customers', ['week' => $week, 'year' => $year, 'lastCustomers' => $lastCustomers]);
    }


}
