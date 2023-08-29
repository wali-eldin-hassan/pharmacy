<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Sales quantity within a year

        $salequantity = DB::table('sales')
            ->select(DB::raw(' COUNT(*) as total, products.p_gname as money'))
            ->join('products', 'products.p_id', '=', 'sales.product_id')
            ->groupBy(DB::raw('products.p_gname LIMIT 10'))
            ->get();

        //Sales money within a year
        $salemoney = DB::table('sales')
            ->select(DB::raw('SUM(sales.price) as money, MONTHNAME(sales.created_at) as month '))
            ->groupBy(DB::raw('DATE_FORMAT(sales.created_at, "%m")'))
            ->get();

        //Amount of purchases within a year
        $apurchases = DB::table('products')
            ->select(DB::raw('SUM(p_imprice) as money, MONTHNAME(created_at) as month '))
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%m")'))
            ->get();

        // Total product
        $totalproduct = DB::table('products')
            ->select(DB::raw('count(p_id) as totalproduct '))
            ->get();
        // Total sales
        $totalsale = DB::table('sales')
            ->select(DB::raw(' SUM(sales.price * ( 100.0 - products.p_discount ) / 100.0) as totalsale '))
            ->join('products', 'products.p_id', '=', 'sales.product_id')
            ->get();
        // Total purchases
        $totalpurchases = DB::table('products')
            ->select(DB::raw(' sum(p_imprice) as totalpurchases'))
            ->get();

        // Last customers
        $customers = DB::table('customers')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        // Last notes
        $note = DB::table('notes')
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();
        // Total product
        $totalcustomers = DB::table('customers')
            ->select(DB::raw('count(id) as customers'))
            ->get();

        $dayProduct = DB::table('products')
            ->selectRaw(' count(p_id)  AS price, DAYNAME(created_at) AS day')
            ->whereRaw('DATE(created_at) = DATE(NOW() - INTERVAL 1 DAY) OR DATE(created_at) =  DATE(NOW())')
            ->groupBy('day')
            ->orderBy('created_at')
            ->get();

        $daySales = DB::table('sales')
            ->selectRaw(' SUM(sales.price * ( 100.0 - products.p_discount ) / 100.0) AS price, DAYNAME(sales.created_at) AS day')
            ->join('products', 'products.p_id', '=', 'sales.product_id')
            ->whereRaw('DATE(sales.created_at) = DATE(NOW() - INTERVAL 1 DAY) OR DATE(sales.created_at) =  DATE(NOW())')
            ->groupBy('day')
            ->orderBy('sales.created_at')
            ->get();

        $dayPurchases = DB::table('products')
            ->selectRaw('sum(products.p_imprice) as price, DAYNAME(products.created_at) AS day')
            ->whereRaw('DATE(products.created_at) = DATE(NOW() - INTERVAL 1 DAY) OR DATE(products.created_at) = DATE(NOW())')
            ->groupBy('day')
            ->orderBy('products.created_at')
            ->get();

        $dayCustomers = DB::table('customers')
            ->selectRaw('count(customers.id) as price, DAYNAME(customers.created_at) AS day')
            ->whereRaw('DATE(customers.created_at) = DATE(NOW() - INTERVAL 1 DAY) OR DATE(customers.created_at) = DATE(NOW())')
            ->groupBy('day')
            ->orderBy('customers.created_at')
            ->get();

        //daySales if today = null or yasterday = null return
        if (!isset($dayProduct[0]) && !isset($dayProduct[1])) {
            $dayProduct = array('yasterday' => '0', 'today' => '0');
        } elseif (!isset($dayProduct[1]->price)) {
            $dayProduct = array('yasterday' => $dayProduct[0]->price, 'today' => '0');
        } elseif (!isset($dayProduct[0]->price)) {
            $dayProduct = array('yasterday' => '0', 'today' => $dayProduct[1]->price);
        } else {
            $dayProduct = array('yasterday' => $dayProduct[0]->price, 'today' => $dayProduct[1]->price);
        }


        //daySales if today = null or yasterday = null return
        if (!isset($daySales[0]->price) && !isset($daySales[1]->price)) {
            $daySales = array('yasterday' => '0', 'today' => '0');
        } elseif (!isset($daySales[1]->price)) {
            $daySales = array('yasterday' => $daySales[0]->price, 'today' => '0');
        } elseif (!isset($daySales[0]->price)) {
            $daySales = array('yasterday' => '0', 'today' => $daySales[1]->price);
        } else {
            $daySales = array('yasterday' => $daySales[0]->price, 'today' => $daySales[1]->price);
        }

        //dayPurchases if today = null or yasterday = null return
        if (!isset($dayPurchases[0]->price) && !isset($dayPurchases[1]->price)) {
            $dayPurchases = array('yasterday' => '0', 'today' => '0');
        } elseif (!isset($dayPurchases[1]->price)) {
            $dayPurchases = array('yasterday' => $dayPurchases[0]->price, 'today' => '0');
        } elseif (!isset($dayPurchases[0]->price)) {
            $dayPurchases = array('yasterday' => '0', 'today' => $dayPurchases[0]->price);
        } else {
            $dayPurchases = array('yasterday' => $dayPurchases[0]->price, 'today' => $dayPurchases[1]->price);
        }

        // dayCustomers if today = null or yasterday = null return
        if (!isset($dayCustomers[0]->price) && !isset($dayCustomers[1]->price)) {
            $dayCustomers = array('yasterday' => '0', 'today' => '0');
        } elseif (!isset($dayCustomers[1]->price)) {
            $dayCustomers = array('yasterday' => $dayCustomers[0]->price, 'today' => '0');
        } elseif (!isset($dayCustomers[0]->price)) {
            $dayCustomers = array('yasterday' => '0', 'today' => $dayCustomers[0]->price);
        } else {
            $dayCustomers = array('yasterday' => $dayCustomers[0]->price, 'today' => $dayCustomers[1]->price);
        }

        return view('home', [
            'salequantity' => $salequantity,
            'salemoney' => $salemoney,
            'apurchases' => $apurchases,
            'totalproduct' => $totalproduct,
            'totalsale' => $totalsale,
            'totalpurchases' => $totalpurchases,
            'totalcustomers' => $totalcustomers,
            'customers' => $customers,
            'note' => $note,
            'dayProduct' => $dayProduct,
            'daySales' => $daySales,
            'dayPurchases' => $dayPurchases,
            'dayCustomers' => $dayCustomers
        ]);
    }

    public function search(Request $request)
    {
        $name = $request->input('search');
        $this->validate($request, array(
            'search' => 'required|max:30',
        ));
        if ($name) {
            $first = DB::table('products')
                ->selectRAW(' "products" AS type, products.p_id ,products.p_gname')
                ->whereRAW("products.p_gname like '%$name%'");

            $second = DB::table('customers')
                ->selectRAW('"customers" AS type, customers.number,customers.name')
                ->whereRAW("customers.name like '%$name%' OR customers.number like '%$name%'");

            $search = DB::table('orders')
                ->selectRAW('"orders" AS type, orders.order_code AS id,orders.invoice_no AS name')
                ->whereRAW("orders.order_code like '%$name%' OR orders.invoice_no like '%$name%'")
                ->union($first)
                ->union($second)
                ->limit(6)
                ->get();
            return response()->json($search);
        }
    }
}
