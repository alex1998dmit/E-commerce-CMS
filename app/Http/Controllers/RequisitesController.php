<?php

namespace App\Http\Controllers;

use App\Requisite;
use Illuminate\Http\Request;

class RequisitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requisites = Requisite::all();
        return view('admin.requisites.index',compact('requisites'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.requisites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'requisite' => 'required',
        ]);

        $requisite = Requisite::create([
            'title' => $request->title,
            'requisite' => $request->requisite,
            'description' => $request->description,
        ]);
        return redirect()->route('requisites');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $requisite = Requisite::find($id);
        return view('admin.requisites.edit',compact('requisite'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,  [
            'title' => 'required',
            'requisite' => 'required',
         ]);

         $requisite = Requisite::find($id);

         $requisite->title = $request->title;
         $requisite->requisite = $request->requisite;
         $requisite->save();
        //  TODO route or view with compact ?
         return redirect()->route('requisites');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $requisite = Requisite::find($id);
        $requisite->delete();
        return redirect()->route('requisites');
    }
}
