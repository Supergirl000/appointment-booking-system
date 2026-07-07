<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportsController extends Controller
{
    public function index(Request $request): View
    {
        $dateFrom = $request->string('date_from')->toString();
        $dateTo = $request->string('date_to')->toString();
        $serviceId = $request->string('service_id')->toString();
        $status = $request->string('status')->toString();
        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];

        $filteredAppointments = $this->filteredAppointments($dateFrom, $dateTo, $serviceId, $status);

        $statusCounts = (clone $filteredAppointments)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $mostRequestedServices = (clone $filteredAppointments)
            ->select('service_id', DB::raw('COUNT(*) as total'))
            ->with('service')
            ->groupBy('service_id')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $appointmentsPerMonth = (clone $filteredAppointments)
            ->selectRaw($this->monthSelectExpression().' as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $estimatedRevenue = (clone $filteredAppointments)
            ->where('appointments.status', 'completed')
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->sum('services.price');

        return view('reports.index', [
            'totalAppointments' => (clone $filteredAppointments)->count(),
            'pendingAppointments' => (int) ($statusCounts['pending'] ?? 0),
            'confirmedAppointments' => (int) ($statusCounts['confirmed'] ?? 0),
            'completedAppointments' => (int) ($statusCounts['completed'] ?? 0),
            'cancelledAppointments' => (int) ($statusCounts['cancelled'] ?? 0),
            'estimatedRevenue' => $estimatedRevenue,
            'mostRequestedServices' => $mostRequestedServices,
            'appointmentsPerMonth' => $appointmentsPerMonth,
            'statusDistribution' => collect($statuses)->mapWithKeys(fn (string $status) => [
                $status => (int) ($statusCounts[$status] ?? 0),
            ]),
            'services' => Service::orderBy('name')->get(),
            'statuses' => $statuses,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'serviceId' => $serviceId,
            'status' => $status,
        ]);
    }

    private function filteredAppointments(string $dateFrom, string $dateTo, string $serviceId, string $status)
    {
        return Appointment::query()
            ->when($dateFrom, function ($query, string $dateFrom) {
                $query->whereDate('appointments.appointment_date', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query, string $dateTo) {
                $query->whereDate('appointments.appointment_date', '<=', $dateTo);
            })
            ->when($serviceId, function ($query, string $serviceId) {
                $query->where('appointments.service_id', $serviceId);
            })
            ->when(in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'], true), function ($query) use ($status) {
                $query->where('appointments.status', $status);
            });
    }

    private function monthSelectExpression(): string
    {
        return DB::connection()->getDriverName() === 'sqlite'
            ? "strftime('%Y-%m', appointment_date)"
            : "DATE_FORMAT(appointment_date, '%Y-%m')";
    }
}
