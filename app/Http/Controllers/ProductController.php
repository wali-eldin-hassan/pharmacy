<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Products;
use App\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Sort by category
        $categorySort = \Request::get('cat');
        $category = Categories::all();
        if (isset($categorySort)) {
            $product = DB::table('products')
                ->join('categories', 'products.p_cat', '=', 'categories.id')
				->leftJoin('sales', 'sales.product_id', '=', 'products.p_id')
                ->selectRAW('products.*, sum(sales.quantity) as sale_quantity,categories.name')
                ->where('p_cat', $categorySort)
				->groupBy('products.p_id')
                ->orderBy('p_id', 'DESC')
                ->paginate(15);
            return view('product.index', ['product' => $product->appends(\Request::except('page')), 'category' => $category]);
        } else {
            $product = DB::table('products')
                ->join('categories', 'products.p_cat', '=', 'categories.id')
                ->leftJoin('sales', 'sales.product_id', '=', 'products.p_id')
                ->selectRAW('products.*, sum(sales.quantity) as sale_quantity,categories.name')
                ->groupBy('products.p_id')
                ->orderBy('p_id', 'DESC')
                ->paginate(15);
            return view('product.index', ['product' => $product, 'category' => $category]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Categories::pluck('name', 'id');
        $provider = Suppliers::pluck('name', 'name');

        return view('product.create', ['category' => $category, 'provider' => $provider]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate data

        $this->validate($request, array(
            'gname' => 'required|max:70',
            'bname' => 'required|nullable|max:70',
            'desc' => 'nullable',
            'country' => 'nullable|max:70',
            'idnumber' => 'required|nullable|max:70',
            'imdate' => 'required|nullable|date',
            'exdate' => 'required|nullable|date',
            'statue' => 'nullable',
            'category' => 'required|max:70',
            'quantity' => 'required|numeric|max:100000000',
            'price' => 'numeric|max:100000000',
            'discount' => 'nullable|numeric|max:100',
            'imname' => 'max:70',
            'immoney' => 'nullable|numeric|max:100000000',

        ));

        //store data
        $product = new Products;
        $product->p_gname = ucfirst($request->gname);
        $product->p_bname = ucfirst($request->bname);
        $product->p_desc = $request->desc;
        $product->p_country = $request->country;
        $product->p_idnumber = $request->idnumber;
        $product->p_imdate = $request->imdate;
        $product->p_exdate = $request->exdate;
        $product->p_seffect = $request->statue;
        $product->p_cat = $request->category;
        $product->p_quantity = $request->quantity;
        $product->p_price = $request->money;
        $product->p_discount = $request->discount;
        $product->p_imname = $request->imname;
        $product->p_imprice = $request->immoney;
        $product->p_barcodeg = $request->barcodeg;

        // if discount empty return 0 
        if (empty($request->discount)) {
            $product->p_discount = 0;
        }

        //upload image
        if ($request->file('file')) {
            $photoName = time() . '.' . $request->file->getClientOriginalExtension();
            $request->file->move('upload', $photoName);
            $product->p_image = $photoName;
        }
        $product->p_icon = $request->icon;
        $product->save();

        session()->flash('success', 'Successful add ' . $product->p_gname . ' product');
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Show product
        if (is_numeric($id)) {
            $product = DB::table('products')
                ->join('categories', 'categories.id', '=', 'products.p_cat')
                ->join('sales', 'sales.product_id', '=', 'products.p_id')
                ->selectRAW(' products.*, sum(sales.quantity) as sale_quantity,categories.name ')
                ->where('p_id', $id)
                ->get();
            return view('product.show')->withproduct($product);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Categories::pluck('name', 'id');
        $product = Products::find($id);
        $provider = Suppliers::pluck('name', 'name');
        return view('product.edit', ['product' => $product, 'category' => $category, 'provider' => $provider]);
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

        //validate data

        $this->validate($request, array(
            'gname' => 'required|max:70',
            'bname' => 'nullable|max:70',
            'desc' => 'nullable',
            'country' => 'nullable|max:70',
            'idnumber' => 'nullable|max:70',
            'imdate' => 'nullable|date',
            'exdate' => 'nullable|date',
            'statue' => 'nullable',
            'category' => 'required|max:70',
            'quantity' => 'required|numeric|max:100000000',
            'price' => 'numeric|max:100000000',
            'discount' => 'nullable|numeric|max:100',
            'imname' => 'max:70',
            'immoney' => 'nullable|numeric|max:100000000',
        ));

        //store data
        $product = Products::find($id);
        $product->p_gname = ucfirst($request->gname);
        $product->p_bname = ucfirst($request->bname);
        $product->p_desc = $request->desc;
        $product->p_country = $request->country;
        $product->p_idnumber = $request->idnumber;
        $product->p_imdate = $request->imdate;
        $product->p_exdate = $request->exdate;
        $product->p_seffect = $request->statue;
        $product->p_cat = $request->category;
        $product->p_quantity = $request->quantity;
        $product->p_price = $request->price;
        $product->p_discount = $request->discount;
        $product->p_imname = $request->imname;
        $product->p_imprice = $request->immoney;
        $product->p_barcodeg = $request->barcodeg;

        // if discount empty return 0 
        if (empty($request->discount)) {
            $product->p_discount = 0;
        }
        //upload image
        if ($request->file('file')) {
            $photoName = time() . '.' . $request->file->getClientOriginalExtension();
            $request->file->move('upload', $photoName);
            $product->p_image = $photoName;
        }
        //check icon not empty
        if (!empty($request->icon)) {
            $product->p_icon = $request->icon;
        }
        $product->save();
        session()->flash('success', 'Successful add ' . $product->p_gname . ' product');
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $product = Products::find($id);
        if ($request->ajax()) {
            $product->delete($request->all());
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
        $name = $request->input('search');
        $this->validate($request, array(
            'search' => 'required|max:30',
        ));
        if ($name) {
            $product = DB::table('products')
                ->join('categories', 'products.p_cat', '=', 'categories.id')
                ->select('products.*', 'categories.name')
                ->where('products.p_gname', 'like', "$name%")
                ->orWhere('products.p_bname', 'like', "$name%")
                ->orWhere('products.p_idnumber', 'like', "$name%")
                ->orWhere('products.p_barcodeg', 'like', "$name%")->get();
            return response()->json($product);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdf($id)
    {
        if ($id === '0') {
            $products = Products::all();
            $pdf = PDF::loadView('product.pdf', ['products' => $products]);
            return $pdf->stream();
        } else {
            $products = DB::table('products')
                ->where('p_cat', $id)
                ->get();
            $pdf = PDF::loadView('product.pdf', ['products' => $products]);
            return $pdf->stream();
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function outstock()
    {
        $product = DB::table('products')
            ->join('categories', 'products.p_cat', '=', 'categories.id')
            ->where('p_quantity', '<', '5')
            ->paginate(15);

        return view('product.outstock', ['product' => $product]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function expired()
    {
        $product = DB::table('products')
            ->join('categories', 'products.p_cat', '=', 'categories.id')
            ->whereRaw('p_exdate < CURDATE()')
            ->paginate(15);

        return view('product.expired', ['product' => $product]);
    }
}
