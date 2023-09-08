<?php

namespace App\Http\Controllers;

use App\Models\Indent;
use App\Models\StockMaster;
use Illuminate\Http\Request;

class IndentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $category = StockMaster::select('category')->orderByRaw('FIELD(category, "Spray" ,"Nutrition" ,"Seeds","others")')->groupBy('category')->get();

        return view('indent/list',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Indent  $indent
     * @return \Illuminate\Http\Response
     */
    public function show(Indent $indent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Indent  $indent
     * @return \Illuminate\Http\Response
     */
    public function edit(Indent $indent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Indent  $indent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Indent $indent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Indent  $indent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Indent $indent)
    {
        //
    }
}
