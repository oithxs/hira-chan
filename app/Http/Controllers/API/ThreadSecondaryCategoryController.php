<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ThreadSecondaryCategory;
use App\Services\ThreadSecondaryCategoryService;
use Illuminate\Http\Request;

class ThreadSecondaryCategoryController extends Controller
{
    private ThreadSecondaryCategoryService $threadSecondaryCategoryService;

    public function __construct()
    {
        $this->threadSecondaryCategoryService = new ThreadSecondaryCategoryService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * 対応する大枠カテゴリを取得する
     */
    public function show(string $id): ThreadSecondaryCategory
    {
        return $this->threadSecondaryCategoryService->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
