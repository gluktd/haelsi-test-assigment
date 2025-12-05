<?php

namespace App\Http\Controllers;

use App\Http\Requests\Service\GetServicesRequest;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * List paginated services ordered by most recent.
     *
     * Returns a paginated collection of services suitable for lists,
     * tables, or infinite scroll views.
     *
     * @operationId listServices
     */
    public function index(GetServicesRequest $request)
    {
        $query = Service::query()->latest();
        if($request->input('type')){
            $query->where('type',$request->input('type'));
        }
        $services = $query->paginate(15);

        return ServiceResource::collection($services);
    }

    /**
     * Create a new service.
     *
     * Accepts validated data and creates a new service record. Returns
     * the created resource.
     *
     * @operationId createService
     */
    public function store(StoreServiceRequest $request)
    {
        $service = Service::query()->create($request->validated());

        return (new ServiceResource($service))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Get a single service by ID.
     *
     * Returns the service resource for the provided identifier.
     *
     * @operationId getService
     */
    public function show(Service $service)
    {
        return new ServiceResource($service);
    }

    /**
     * Update an existing service.
     *
     * Applies validated changes to the specified service and returns the
     * updated resource.
     *
     * @operationId updateService
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

        return new ServiceResource($service);
    }

    /**
     * Delete a service.
     *
     * Permanently removes the specified service and returns a 204 No
     * Content response on success.
     *
     * @operationId deleteService
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return response()->noContent();
    }
}
