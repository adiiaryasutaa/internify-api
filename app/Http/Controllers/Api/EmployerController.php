<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreEmployerRequest;
use App\Http\Requests\Api\UpdateEmployerRequest;
use App\Models\Employer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployerController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Employer/Index', [
            'employers' => Employer::with(['user'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Employer/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployerRequest $request)
    {
        $request = $request->safe();

        try {
            $employer = DB::transaction(function () use ($request) {
                $employer = Employer::create();

                $user = $employer->user()->create($request->only(['name', 'email', 'username', 'password']));

                tap($user, function (User $user) use ($request) {
                    if ($request->has('photo')) {
                        $user->updateProfilePhoto($request->photo);
                    }
                });

                return $employer;
            });

            return redirect()
                ->route('employer.show', compact('employer'))
                ->with(['create.success' => __('Employer created successfully.')]);
        } catch (Exception $e) {
            return back()
                ->with(['create.failed' => __('Failed to create employer. Please try again.')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employer $employer)
    {
        return inertia('Employer/Show', [
            'employer' => $employer->loadMissing(['user']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employer $employer)
    {
        return inertia('Employer/Edit', [
            'employer' => $employer->loadMissing(['user']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployerRequest $request, Employer $employer)
    {
        $request = $request->safe();

        try {
            DB::transaction(function () use ($request, $employer) {
                $user = $employer->user()->update($request->only(['name', 'email', 'username', 'password']));

                tap($user, function (User $user) use ($request) {
                    if ($request->has('photo')) {
                        $user->updateProfilePhoto($request->photo);
                    }
                });

                return $employer;
            });

            return back()
                ->with(['update.success' => __('Employer updated successfully.')]);
        } catch (Exception $e) {
            return back()
                ->with(['update.failed' => __('Failed to update employer. Please try again.')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employer $employer)
    {
        try {
            DB::transaction(function () use ($employer) {
                return $employer->delete();
            });

            return back()
                ->with(['delete.success' => __('Employer deleted successfully.')]);
        } catch (Exception $e) {
            return back()
                ->with(['delete.failed' => __('Failed to delete employer. Please try again.')]);
        }
    }
}
