<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = now()->toDateString();

        $todaysAppointments = Appointment::with(['customer', 'service', 'staff'])
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_time')
            ->get();

        return view('dashboard.index', [
            'todaysAppointments' => $todaysAppointments,
            'todaysAppointmentsCount' => $todaysAppointments->count(),
            'upcomingAppointmentsCount' => Appointment::whereDate('appointment_date', '>', $today)->count(),
            'customersCount' => Customer::count(),
            'servicesCount' => Service::count(),
        ]);
    }
}
