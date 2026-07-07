<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Staff;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalendarController extends Controller
{
    public function index(Request $request): View
    {
        $month = $this->resolveMonth($request->string('month')->toString());
        $status = $request->string('status')->toString();
        $staffId = $request->string('staff_id')->toString();
        $serviceId = $request->string('service_id')->toString();

        $calendarStart = $month->copy()->startOfMonth()->startOfWeek();
        $calendarEnd = $month->copy()->endOfMonth()->endOfWeek();

        $appointmentsByDate = Appointment::with(['customer', 'service', 'staff'])
            ->whereBetween('appointment_date', [
                $calendarStart->toDateString(),
                $calendarEnd->toDateString(),
            ])
            ->when(in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'], true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($staffId, function ($query, string $staffId) {
                $query->where('staff_id', $staffId);
            })
            ->when($serviceId, function ($query, string $serviceId) {
                $query->where('service_id', $serviceId);
            })
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get()
            ->groupBy(fn (Appointment $appointment) => $appointment->appointment_date->toDateString());

        return view('calendar.index', [
            'appointmentsByDate' => $appointmentsByDate,
            'calendarDays' => collect(CarbonPeriod::create($calendarStart, $calendarEnd)),
            'month' => $month,
            'previousMonth' => $month->copy()->subMonth()->format('Y-m'),
            'nextMonth' => $month->copy()->addMonth()->format('Y-m'),
            'currentMonth' => now()->format('Y-m'),
            'status' => $status,
            'staffId' => $staffId,
            'serviceId' => $serviceId,
            'staffMembers' => Staff::orderBy('name')->get(),
            'services' => Service::orderBy('name')->get(),
            'statuses' => ['pending', 'confirmed', 'completed', 'cancelled'],
        ]);
    }

    private function resolveMonth(string $month): Carbon
    {
        if (! $month) {
            return now()->startOfMonth();
        }

        try {
            return Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        } catch (\Throwable) {
            return now()->startOfMonth();
        }
    }
}
