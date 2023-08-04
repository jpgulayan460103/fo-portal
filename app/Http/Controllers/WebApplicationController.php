<?php

namespace App\Http\Controllers;

use App\Models\WebApplication;
use Illuminate\Http\Request;

class WebApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $webApplications = WebApplication::orderBy('application_name')
            ->orWhere('application_name', 'like', "%$request->keywords%")
            ->orWhere('application_description', 'like', "%$request->keywords%")
            ->orWhere('keywords', 'like', "%$request->keywords%")
            ->get();
        return [
            'webApplications' => $webApplications,
        ];
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
     * @param  \App\Models\WebApplication  $webApplication
     * @return \Illuminate\Http\Response
     */
    public function show(WebApplication $webApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WebApplication  $webApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(WebApplication $webApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WebApplication  $webApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WebApplication $webApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WebApplication  $webApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(WebApplication $webApplication)
    {
        //
    }
}
