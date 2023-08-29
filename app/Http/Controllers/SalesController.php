<?php

namespace App\Http\Controllers;

use App\Orders;
use App\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $getLastId = sales::all()->last();

        $print = DB::table('sales')
            ->select(DB::raw('sales.quantity,orders.invoice_no,sales.info,products.p_id,products.p_discount,products.p_barcodeg,products.p_discount,sales.order_code,products.p_bname AS name, sales.price AS price,orders.created_at'))
            ->join('products', 'products.p_id', '=', 'sales.product_id')
            ->join('orders', 'orders.order_code', '=', 'sales.order_code')
            ->where('sales.order_code', $getLastId['order_code'])
            ->get();

        $sales = DB::table('orders')
            ->select(DB::raw('sales.order_code,products.p_id,orders.invoice_no ,products.p_discount, GROUP_CONCAT(products.p_bname SEPARATOR "," ) AS name,  SUM(sales.price * ( 100.0 - products.p_discount ) / 100.0) AS price , sales.created_at'))
            ->join('sales', 'sales.order_code', '=', 'orders.order_code')
            ->join('products', 'products.p_id', '=', 'sales.product_id')
            ->groupBy('sales.order_code')
            ->orderBy('orders.id', 'desc')
            ->paginate(40);

        return view('sales.index', ['sales' => $sales, 'print' => $print]);
    }

    /**
     * Show the form for sale a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = DB::table('products')
            ->select('p_bname', 'p_id', 'p_price', 'p_icon', 'p_discount', 'p_seffect', 'p_desc')
            ->get();
        return view('sales.create', ['product' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'productID' => 'required|max:10',
            'orderPrice' => 'required|max:10',
            'orderQuantity' => 'required|max:10',
        ));
        $id = $request->input('productID');
        $price = $request->input('orderPrice');
        $order_info = $request->input('orderInfo');
        $order_quantity = $request->input('orderQuantity');
        $code = rand(5, 10000000000);

        //store $order_code to orders table
        if (!empty(Orders::all()->last()->id)) {
            $invoice = Orders::all()->last()->id;
        } else {
            $invoice = 0;
        }
        $order = new Orders();
        $order->order_code = $code;
        $order->invoice_no = date('Y') . '000' . $invoice;
        $order->save();
        $isdone = true;

        // check if there id and price then store in to sales table
        if ($id && $price) {
            foreach ($id as $key => $value) {
                $sale = new Sales();
                $sale->order_code = $code;
                $sale->info = $order_info[$key];
                $sale->price = $price[$key];
                $sale->quantity = $order_quantity[$key];
                $sale->product_id = $id[$key];
                $sale->save();
            }
        }

        // session message and redirect
        if ($isdone === true) {
            session()->flash('success', 'Successful sale');
            return redirect()->route('sales.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = DB::table('sales')
            ->join('products', 'products.p_id', '=', 'sales.product_id')
            ->selectRAW('sum(sales.quantity) AS quantity, sales.product_id,sales.created_at,order_code,products.p_discount,sales.price AS price , sales.info AS info, products.p_bname AS name')
            ->where('order_code', $id)
            ->get();
        return view('sales.show', ['sale' => $sale]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->validate($request, array(
            'id' => 'numeric',
        ));
        if ($request->ajax()) {
            $sale = Sales::where('order_code', $id);
            $sale->delete($request->all());
            return response(['msg' => 'Product deleted', 'status' => 'success']);
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
    }

    /**
     * Search the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response Json
     */

    public function search(Request $request)
    {
        $number = $request->input('search');
        $this->validate($request, array(
            'search' => 'required|max:30',
        ));
        if ($number) {
            $sales = DB::table('sales')
                ->selectRAW(' orders.invoice_no,sales.order_code,products.p_gname AS name, sum(sales.price) AS price,orders.created_at')
                ->join('products', 'products.p_id', '=', 'sales.product_id')
                ->join('orders', 'orders.order_code', '=', 'sales.order_code')
                ->where('orders.invoice_no', 'like', "$number%")
                ->groupBy('sales.order_code')
                ->get();
            return response()->json($sales);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function pdf($id)
    {
        if (is_numeric($id)) {
            if ($id === '0') {
                $sales = DB::table('orders')
                    ->selectRAW('orders.invoice_no ,GROUP_CONCAT(products.p_bname SEPARATOR "," ) AS name,  SUM(sales.price * ( 100.0 - products.p_discount ) / 100.0) AS price , sales.created_at')
                    ->join('sales', 'sales.order_code', '=', 'orders.order_code')
                    ->join('products', 'products.p_id', '=', 'sales.product_id')
                    ->groupBy('sales.order_code')
                    ->get();
            } elseif ($id === '1') {
                $sales = DB::table('orders')
                    ->selectRAW('orders.invoice_no ,GROUP_CONCAT(products.p_bname SEPARATOR "," ) AS name,  SUM(sales.price * ( 100.0 - products.p_discount ) / 100.0) AS price , sales.created_at')
                    ->join('sales', 'sales.order_code', '=', 'orders.order_code')
                    ->join('products', 'products.p_id', '=', 'sales.product_id')
                    ->groupBy('sales.order_code')
                    ->whereRaw('sales.created_at between date_sub(now(),INTERVAL 1 WEEK) and now()')
                    ->get();
            } elseif ($id === '2') {
                $sales = DB::table('orders')
                    ->selectRAW('orders.invoice_no ,GROUP_CONCAT(products.p_bname SEPARATOR "," ) AS name,  SUM(sales.price * ( 100.0 - products.p_discount ) / 100.0) AS price , sales.created_at')
                    ->join('sales', 'sales.order_code', '=', 'orders.order_code')
                    ->join('products', 'products.p_id', '=', 'sales.product_id')
                    ->groupBy('sales.order_code')
                    ->whereRaw('sales.created_at between date_sub(now(),INTERVAL 1 MONTH) and now()')
                    ->get();
            } elseif ($id === '3') {
                $sales = DB::table('orders')
                    ->selectRAW('orders.invoice_no ,GROUP_CONCAT(products.p_bname SEPARATOR "," ) AS name,  SUM(sales.price * ( 100.0 - products.p_discount ) / 100.0) AS price , sales.created_at')
                    ->join('sales', 'sales.order_code', '=', 'orders.order_code')
                    ->join('products', 'products.p_id', '=', 'sales.product_id')
                    ->groupBy('sales.order_code')
                    ->whereRaw('sales.created_at between date_sub(now(),INTERVAL 6 MONTH) and now()')
                    ->get();
            } elseif ($id === '4') {
                $sales = DB::table('orders')
                    ->selectRAW('orders.invoice_no ,GROUP_CONCAT(products.p_bname SEPARATOR "," ) AS name,  SUM(sales.price * ( 100.0 - products.p_discount ) / 100.0) AS price , sales.created_at')
                    ->join('sales', 'sales.order_code', '=', 'orders.order_code')
                    ->join('products', 'products.p_id', '=', 'sales.product_id')
                    ->groupBy('sales.order_code')
                    ->whereRaw('sales.created_at between date_sub(now(),INTERVAL 1 YEAR) and now()')
                    ->get();
            }

            $pdf = PDF::loadView('sales.pdf', ['sales' => $sales]);
            return $pdf->download('sales.pdf');
        }
    }

    public function getInvoice($id)
    {
        $print = DB::table('sales')
            ->selectRAW('sales.quantity,orders.invoice_no,sales.info,products.p_id,products.p_discount,products.p_barcodeg,products.p_discount,sales.order_code,products.p_bname AS name, sales.price AS price,orders.created_at')
            ->join('products', 'products.p_id', '=', 'sales.product_id')
            ->join('orders', 'orders.order_code', '=', 'sales.order_code')
            ->where('sales.order_code', $id)
            ->get();
        return view('sales.invoice', ['print' => $print]);
    }
}
