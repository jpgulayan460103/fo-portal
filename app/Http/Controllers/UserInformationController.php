<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\UserInformation  $userInformation
     * @return \Illuminate\Http\Response
     */
    public function show(UserInformation $userInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserInformation  $userInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(UserInformation $userInformation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserInformation  $userInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $auth_user = Auth::user();
        $user = User::findOrFail($auth_user->id);
        $user->user_information()->updateOrCreate($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserInformation  $userInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserInformation $userInformation)
    {
        //
    }
}
