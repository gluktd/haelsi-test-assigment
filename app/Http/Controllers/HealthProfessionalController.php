<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHealthProfessionalRequest;
use App\Http\Requests\UpdateHealthProfessionalRequest;
use App\Http\Resources\HealthProfessionalResource;
use App\Models\HealthProfessional;

class HealthProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pros = HealthProfessional::query()->latest()->paginate(15);
        return HealthProfessionalResource::collection($pros);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHealthProfessionalRequest $request)
    {
        $pro = HealthProfessional::create($request->validated());
        return (new HealthProfessionalResource($pro))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(HealthProfessional $healthProfessional)
    {
        return new HealthProfessionalResource($healthProfessional);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHealthProfessionalRequest $request, HealthProfessional $healthProfessional)
    {
        $healthProfessional->update($request->validated());
        return new HealthProfessionalResource($healthProfessional);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HealthProfessional $healthProfessional)
    {
        $healthProfessional->delete();
        return response()->noContent();
    }
}
