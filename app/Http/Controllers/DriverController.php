<?php

namespace App\Http\Controllers;

use App\Http\Resources\DriverDetail;
use App\Http\Resources\DriverList;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DriverList::collection(Driver::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        return new DriverDetail($driver);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
    }

    public function hotlaps(Driver $driver)
    {
        return $driver->hotlaps;
    }

    public function metrics(Driver $driver)
    {
        return $driver->metrics;
    }
}
