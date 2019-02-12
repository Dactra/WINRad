<?php

namespace App\Http\Controllers\Admin;

use App\Radwin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RadwinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $radwins = Radwin::all();
      return view('admin.radwins.index', compact('radwins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.radwins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      Radwin::create($request->all());
      return redirect()->route('admin.radwins.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Radwin  $radwin
     * @return \Illuminate\Http\Response
     */
    public function show(Radwin $radwin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Radwin  $radwin
     * @return \Illuminate\Http\Response
     */
    public function edit(Radwin $radwin)
    {
        return view('admin.radwins.edit', compact('radwin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Radwin  $radwin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Radwin $radwin)
    {
      $radwin->update($request->all());
      return redirect()->route('admin.radwins.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Radwin  $radwin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Radwin $radwin)
    {
        //
    }
}
