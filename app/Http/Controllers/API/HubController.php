<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\HubService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class HubController extends Controller
{
    private HubService $hubService;

    public function __construct()
    {
        $this->hubService = new HubService();
    }

    /**
     * スレッド一覧を表示する
     */
    public function index(): Collection
    {
        return $this->hubService->index();
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
