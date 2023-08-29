<?php

namespace App\Http\Controllers;

use App\Customers;
use App\Custorders;
use App\Lastcs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = DB::table('customers')
            ->paginate(40);
        return view('customers.index', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = DB::table('products')
            ->select('p_gname', 'p_id', 'p_price', 'p_icon', 'p_discount')
            ->get();
        return view('customers.create', ['product' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!empty($request->phone)) {
            $this->validate($request, array(
                'productID' => 'required|max:10',
                'orderPrice' => 'required|max:10',
                'orderQuantity' => 'required|max:10',
                'name' => 'required|max:70',
                'address' => 'required|max:50',
                'phone' => 'required|max:20',
                'info' => 'required|nullable',
            ));

            $id = $request->input('productID');
            $price = $request->input('orderPrice');
            $order_info = $request->input('orderInfo');
            $order_quantity = $request->input('orderQuantity');
            $code = rand(5, 10000000000);

            //store $order_code to orders table
            $order = new Customers();
            $order->number = $code;
            $order->name = $request->input('name');
            $order->address = $request->input('address');
            $order->phone = $request->input('phone');
            $order->info = $request->input('info');

            $order->save();
            $isdone = true;

            // check if there id and price then store in to sales table
            if ($id && $price) {
                foreach ($id as $key => $value) {
                    $sale = new Custorders();
                    $sale->cust_no = $code;
                    $sale->info = $order_info[$key];
                    $sale->price = $price[$key];
                    $sale->quantity = $order_quantity[$key];
                    $sale->product_id = $id[$key];
                    $sale->save();
                }
            }

            // session message and redirect
            if ($isdone === true) {
                session()->flash('success', 'Successful add' . $order->name);
                return redirect()->route('customers.show', ['id' => $sale->cust_no]);
            }

            // order print
        } else {
            $this->validate($request, array(
                'customerno' => 'required|max:30',
            ));

            // Customer sales store
            $cs = new Lastcs();
            $cs->cust_no = $request->input('customerno');
            $cs->save();

            session()->flash('success', 'Successful selling ' . $cs->cust_no);
            return redirect()->route('customers.show', ['id' => $cs->cust_no]);
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
        $custorders = DB::table('custorders')
            ->join('products', 'products.p_id', '=', 'custorders.product_id')
            ->join('customers', 'customers.number', '=', 'custorders.cust_no')
            ->select(DB::raw('customers.name,customers.address,customers.phone,customers.info,custorders.product_id,custorders.created_at,custorders.quantity,custorders.cust_no AS customer_number, custorders.price AS price , custorders.info AS druginfo, sum(custorders.quantity) , products.p_gname AS drugname, products.p_discount AS discount,products.p_barcodeg AS barcode'))
            ->where('custorders.cust_no', $id)
            ->get();

        $lastsale = DB::table('lastcs')
            ->where('cust_no', $id)
            ->get();
        return view('customers.show', ['custorders' => $custorders, 'lastsale' => $lastsale]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customers = Customers::find($id);
        return view('customers.edit', ['customers' => $customers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //validate input
        $this->validate($request, array(

            'name' => 'required|max:70',
            'address' => 'required|max:50',
            'phone' => 'required|max:20',
            'price' => 'nullable|max:10',
            'info' => 'nullable',

        ));
        // Store data
        $customer = Customers::find($id);
        $customer->name = $request->input('name');
        $customer->address = $request->input('address');
        $customer->phone = $request->input('phone');
        $customer->info = $request->input('info');

        $customer->save();

        session()->flash('success', 'Successful update ' . $customer->name);
        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $customers = Customers::find($id);
        if ($request->ajax()) {
            $customers->delete($request->all());
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

    public function search(request $request)
    {
        $name = $request->input('search');
        $this->validate($request, array(
            'search' => 'required|max:30',
        ));
        if ($name) {
            $customers = db::table('customers')
                ->where('name', 'like', "$name%")
                ->orWhere('number', 'like', "$name%")->get();
            return response()->json($customers);
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
                $customers = Customers::all();
            } elseif ($id === '1') {
                $customers = DB::table('customers')
                    ->whereRaw('created_at between date_sub(now(),INTERVAL 1 WEEK) and now()')
                    ->get();
            } elseif ($id === '2') {
                $customers = DB::table('customers')
                    ->whereRaw('created_at between date_sub(now(),INTERVAL 1 MONTH) and now()')
                    ->get();
            } elseif ($id === '3') {
                $customers = DB::table('customers')
                    ->whereRaw('created_at between date_sub(now(),INTERVAL 6 MONTH) and now()')
                    ->get();
            } elseif ($id === '4') {
                $customers = DB::table('customers')
                    ->whereRaw('created_at between date_sub(now(),INTERVAL 1 Year) and now()')
                    ->get();
            }

            $pdf = PDF::loadView('customers.pdf', ['customers' => $customers]);
            return $pdf->download('customers.pdf');
        }
    }
}
