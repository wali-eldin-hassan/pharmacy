<?php

namespace App\Http\Controllers;

use App\Notes;
use Illuminate\Http\Request;

class ToolsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function discount()
    {
        return view('tools.discount');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dsearch()
    {
        return view('tools.dsearch');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function note()
    {
        $note = Notes::all();
        return view('tools.note', ['note' => $note]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function noteStore(Request $request)
    {
        $this->validate($request, array(

            'noteName' => 'nullable|max:30',
            'noteText' => 'required|max:200',
            'noteColor' => 'nullable|max:200',

        ));
        if ($request->ajax()) {
            $note = new Notes();
            $note->name = $request->input('noteName');
            $note->content = $request->input('noteText');
            $note->color = $request->input('noteColor');
            $note->save();
            return response(['msg' => $note, 'status' => 'success']);
        } else {
            return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function noteUpdate(Request $request, $id)
    {
        $this->validate($request, array(

            'noteName' => 'nullable|max:30',
            'noteText' => 'required|max:200',
            'noteColor' => 'nullable|max:200',

        ));
        if ($request->ajax()) {
            $note = Notes::find($id);
            $note->name = $request->input('noteName');
            $note->content = $request->input('noteText');
            $note->color = (!empty($request->input('noteColor')) ? $request->input('noteColor') : 'White');
            $note->save();
            return response(['msg' => 'Product deleted', 'status' => 'success']);
        } else {
            return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function noteDestroy(Request $request, $id)
    {
        $note = Notes::find($id);
        if ($request->ajax()) {
            $note->delete($request->all());
            return response(['msg' => 'Product deleted', 'status' => 'success']);
        }
        return response(['msg' => 'Failed deleting the product', 'status' => 'failed']);
    }
}
