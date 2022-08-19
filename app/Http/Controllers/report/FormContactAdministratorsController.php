<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use App\Models\ContactAdministrators;
use App\Http\Requests\report\FormContactAdministratorsRequest;

use Illuminate\Http\Request;

class FormContactAdministratorsController extends Controller
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
     * @return \Illuminate\Support\Facades\View
     */
    public function create()
    {
        return view('report.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\report\FormContactAdministratorsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormContactAdministratorsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactAdministrators  $contactAdministrators
     * @return \Illuminate\Http\Response
     */
    public function show(ContactAdministrators $contactAdministrators)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactAdministrators  $contactAdministrators
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactAdministrators $contactAdministrators)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactAdministrators  $contactAdministrators
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactAdministrators $contactAdministrators)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactAdministrators  $contactAdministrators
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactAdministrators $contactAdministrators)
    {
        //
    }
}
