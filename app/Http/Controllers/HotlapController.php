<?php

namespace App\Http\Controllers;

use App\Http\Resources\HotlapList;
use App\Models\Hotlap;
use Illuminate\Http\Request;

class HotlapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return HotlapList::collection(Hotlap::orderBy('created_at', 'DESC')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Hotlap $hotlap) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hotlap $hotlap) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotlap $hotlap) {}
}
