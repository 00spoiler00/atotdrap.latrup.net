<?php

namespace App\Http\Controllers;

use App\Http\Resources\EnrollmentDetail;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        return new EnrollmentDetail($enrollment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment) {}
}
