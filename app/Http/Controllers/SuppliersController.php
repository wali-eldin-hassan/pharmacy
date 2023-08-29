<?php

namespace App\Http\Controllers;

use App\Suppliers;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Suppliers::all();
        return view('suppliers.index', ['suppliers' => $suppliers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suppliers.create');
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

            'name' => 'required|max:30',
            'address' => 'required|max:70',
            'telephone' => 'required|numeric',
            'fax' => 'required|numeric',
            'info' => 'required|max:255',
        ));
        $suppliers = new Suppliers();
        $suppliers->name = $request->input('name');
        $suppliers->address = $request->input('address');
        $suppliers->phone = $request->input('telephone');
        $suppliers->fax = $request->input('fax');
        $suppliers->info = $request->input('info');
        $suppliers->save();
        session()->flash('success', 'Successful add.');
        return redirect()->route('suppliers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $suppliers = Suppliers::find($id);
        return view('suppliers.edit')->withsuppliers($suppliers);
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
        $this->validate($request, array(
            'name' => 'required|max:30',
            'address' => 'required|max:70',
            'telephone' => 'required|numeric',
            'fax' => 'required|numeric',
            'info' => 'required|max:255',
        ));
        $suppliers = Suppliers::find($id);
        $suppliers->name = $request->input('name');
        $suppliers->address = $request->input('address');
        $suppliers->phone = $request->input('telephone');
        $suppliers->fax = $request->input('fax');
        $suppliers->info = $request->input('info');
        $suppliers->save();
        session()->flash('success', 'Successful update.');
        return redirect()->route('suppliers.index');
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
            $suppliers = Suppliers::find($id);
            $suppliers->delete($request->all());
            return response(['msg' => 'Product deleted', 'status' => 'success']);
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
    }
}
