<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHealthProfessionalRequest;
use App\Http\Requests\UpdateHealthProfessionalRequest;
use App\Http\Resources\HealthProfessionalResource;
use App\Models\HealthProfessional;

class HealthProfessionalController extends Controller
{
    /**
     * List paginated health professionals ordered by most recent.
     *
     * Returns a paginated collection of health professionals for use in
     * lists, tables, or infinite scrolling UIs.
     *
     * @operationId listHealthProfessionals
     */
    public function index()
    {
        $pros = HealthProfessional::query()->latest()->paginate(15);

        return HealthProfessionalResource::collection($pros);
    }

    /**
     * Create a new health professional.
     *
     * Accepts validated data and creates a new health professional record.
     * Returns the created resource.
     *
     * @operationId createHealthProfessional
     */
    public function store(StoreHealthProfessionalRequest $request)
    {
        $pro = HealthProfessional::query()->create($request->validated());

        return (new HealthProfessionalResource($pro))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Get a single health professional by ID.
     *
     * Returns the health professional resource for the provided identifier.
     *
     * @operationId getHealthProfessional
     */
    public function show(HealthProfessional $healthProfessional)
    {
        return new HealthProfessionalResource($healthProfessional);
    }

    /**
     * Update an existing health professional.
     *
     * Applies validated changes to the specified health professional and
     * returns the updated resource.
     *
     * @operationId updateHealthProfessional
     */
    public function update(UpdateHealthProfessionalRequest $request, HealthProfessional $healthProfessional)
    {
        $healthProfessional->update($request->validated());

        return new HealthProfessionalResource($healthProfessional);
    }

    /**
     * Delete a health professional.
     *
     * Permanently removes the specified health professional and returns a
     * 204 No Content response on success.
     *
     * @operationId deleteHealthProfessional
     */
    public function destroy(HealthProfessional $healthProfessional)
    {
        $healthProfessional->delete();

        return response()->noContent();
    }
}
