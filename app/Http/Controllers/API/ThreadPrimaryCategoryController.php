<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ThreadSecondaryCategoryService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ThreadPrimaryCategoryController extends Controller
{
    private ThreadSecondaryCategoryService $threadSecondaryCategoryService;

    public function __construct()
    {
        $this->threadSecondaryCategoryService = new ThreadSecondaryCategoryService();
    }

    /**
     * 大枠カテゴリ一覧を取得する
     *
     * @return Collection 大枠カテゴリ一覧
     */
    public function index(): Collection
    {
        return $this->threadSecondaryCategoryService->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
