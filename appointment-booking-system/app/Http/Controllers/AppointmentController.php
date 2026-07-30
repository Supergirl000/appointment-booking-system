<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();
        $date = $request->string('date')->toString();

        $appointments = Appointment::query()
            ->with(['customer', 'service', 'staff'])
            ->when($search, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('customer', function ($query) use ($search) {
                        $query->where('full_name', 'like', "%{$search}%");
                    })->orWhereHas('service', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->when(in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'], true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($date, function ($query, string $date) {
                $query->whereDate('appointment_date', $date);
            })
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->paginate(10)
            ->withQueryString();

        return view('appointments.index', compact('appointments', 'search', 'status', 'date'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('appointments.create', [
            'appointment' => new Appointment(['status' => 'pending']),
            ...$this->formOptions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request): RedirectResponse
    {
        $appointment = Appointment::create($request->validated());

        return redirect()
            ->route('appointments.show', $appointment)
            ->with('success', __('Appointment created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment): View
    {
        $appointment->load(['customer', 'service', 'staff']);

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment): View
    {
        return view('appointments.edit', [
            'appointment' => $appointment,
            ...$this->formOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment): RedirectResponse
    {
        $appointment->update($request->validated());

        return redirect()
            ->route('appointments.show', $appointment)
            ->with('success', __('Appointment updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()
            ->route('appointments.index')
            ->with('success', __('Appointment deleted successfully.'));
    }

    private function formOptions(): array
    {
        return [
            'customers' => Customer::orderBy('full_name')->get(),
            'services' => Service::orderBy('name')->get(),
            'staffMembers' => Staff::where('status', 'active')->orderBy('name')->get(),
            'statuses' => ['pending', 'confirmed', 'completed', 'cancelled'],
        ];
    }
}
