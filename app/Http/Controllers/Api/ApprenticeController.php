<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreApprenticeRequest;
use App\Http\Requests\Api\UpdateApprenticeRequest;
use App\Models\Apprentice;

class ApprenticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Apprentice/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Apprentice/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApprenticeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Apprentice $apprentice)
    {
        return inertia('Apprentice/Show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apprentice $apprentice)
    {
        return inertia('Apprentice/Edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApprenticeRequest $request, Apprentice $apprentice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apprentice $apprentice)
    {
        //
    }
}
