<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\FormContactAdministratorRequest;
use App\Models\ContactAdministrator;
use App\Services\ContactAdministratorService;
use Illuminate\Http\Request;

class FormContactAdministratorController extends Controller
{
    private ContactAdministratorService $contactAdministratorService;

    public function __construct()
    {
        $this->contactAdministratorService = new ContactAdministratorService;
    }

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
     * [GET] お問い合わせ（報告）用のフォームを表示する．
     *
     * @link https://readouble.com/laravel/9.x/ja/views.html
     * @see resources/views/report/form.blade.php
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function create()
    {
        return view('report.form');
    }

    /**
     * [POST] フォームに入力された値を検証し，DBに保存する．
     *
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     * @see \App\Http\Requests\Report\FormContactAdministratorRequest
     *
     * @param  \App\Http\Requests\report\FormContactAdministratorRequest $request
     * @return void
     */
    public function store(FormContactAdministratorRequest $request)
    {
        $this->contactAdministratorService->store(
            $request->radio_1,
            $request->user()->id,
            $request->report_form_textarea
        );
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
