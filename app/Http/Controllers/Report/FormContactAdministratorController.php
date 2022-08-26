<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\FormContactAdministratorRequest;
use App\Models\ContactAdministrator;
use Illuminate\Http\Request;

class FormContactAdministratorController extends Controller
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
     * @param  \App\Http\Requests\report\FormContactAdministratorRequest $request
     * @return void
     */
    public function store(FormContactAdministratorRequest $request)
    {
        ContactAdministrator::create([
            'type' => $request->radio_1,
            'report_email' => $request->user()->email,
            'message' => $request->report_form_textarea
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactAdministrator  $contactAdministrators
     * @return \Illuminate\Http\Response
     */
    public function show(ContactAdministrator $contactAdministrators)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactAdministrator  $contactAdministrators
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactAdministrator $contactAdministrators)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactAdministrator  $contactAdministrators
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactAdministrator $contactAdministrators)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactAdministrator  $contactAdministrators
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactAdministrator $contactAdministrators)
    {
        //
    }
}
