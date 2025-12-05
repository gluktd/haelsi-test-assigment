<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    /**
     * List paginated appointments ordered by most recent.
     *
     * Returns a paginated collection of appointments. Useful for building
     * lists, tables, or infinite scrolls on the client.
     *
     * @operationId listAppointments
     */
    public function index()
    {
        $appointments = Appointment::query()->latest()->paginate(15);

        return AppointmentResource::collection($appointments);
    }

    /**
     * Create a new appointment.
     *
     * Accepts validated appointment data and creates a new appointment
     * record. Returns the created resource.
     *
     * @operationId createAppointment
     */
    public function store(StoreAppointmentRequest $request)
    {
        $appointment = Appointment::query()->create($request->validated());

        return (new AppointmentResource($appointment))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Get a single appointment by ID.
     *
     * Returns the appointment resource for the provided identifier.
     *
     * @operationId getAppointment
     */
    public function show(Appointment $appointment)
    {
        return new AppointmentResource($appointment);
    }

    /**
     * Update an existing appointment.
     *
     * Applies the provided validated data to the specified appointment
     * and returns the updated resource.
     *
     * @operationId updateAppointment
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->validated());

        return new AppointmentResource($appointment);
    }

    /**
     * Delete an appointment.
     *
     * Permanently removes the specified appointment and returns an empty
     * 204 No Content response on success.
     *
     * @operationId deleteAppointment
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->noContent();
    }
}
