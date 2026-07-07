<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class AppointmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointment::query()->delete();

        $appointments = [
            [
                'customer' => 'Ava Johnson',
                'service' => 'Signature Glow Facial',
                'staff' => 'Grace Lee',
                'date' => now()->toDateString(),
                'time' => '09:00',
                'status' => 'confirmed',
                'notes' => 'Prepare fragrance-free products and gentle exfoliation.',
            ],
            [
                'customer' => 'Sophia Williams',
                'service' => 'Luxury Gel Manicure',
                'staff' => 'Isabella Miller',
                'date' => now()->toDateString(),
                'time' => '10:30',
                'status' => 'pending',
                'notes' => 'Client requested neutral bridal color options.',
            ],
            [
                'customer' => 'Noah Anderson',
                'service' => 'Deep Tissue Therapy',
                'staff' => 'Noah Davis',
                'date' => now()->toDateString(),
                'time' => '14:00',
                'status' => 'confirmed',
                'notes' => 'Focus on shoulders and lower back.',
            ],
            [
                'customer' => 'Lily Thompson',
                'service' => 'Event Hair Styling',
                'staff' => 'Olivia Smith',
                'date' => now()->addDay()->toDateString(),
                'time' => '11:00',
                'status' => 'confirmed',
                'notes' => 'Trial look for bridal event.',
            ],
            [
                'customer' => 'Olivia Martinez',
                'service' => 'Wellness Consultation',
                'staff' => 'Grace Lee',
                'date' => now()->addDays(2)->toDateString(),
                'time' => '15:30',
                'status' => 'pending',
                'notes' => 'Review wellness plan and treatment goals.',
            ],
            [
                'customer' => 'Ethan Brooks',
                'service' => 'Business Strategy Session',
                'staff' => 'Daniel King',
                'date' => now()->addDays(4)->toDateString(),
                'time' => '13:00',
                'status' => 'confirmed',
                'notes' => 'Discuss booking workflow and staff utilization.',
            ],
            [
                'customer' => 'Amelia Scott',
                'service' => 'Skin Analysis Appointment',
                'staff' => 'Grace Lee',
                'date' => now()->addDays(7)->toDateString(),
                'time' => '12:00',
                'status' => 'confirmed',
                'notes' => 'Client interested in monthly skin care plan.',
            ],
            [
                'customer' => 'Mia Carter',
                'service' => 'Signature Glow Facial',
                'staff' => 'Grace Lee',
                'date' => now()->subDays(3)->toDateString(),
                'time' => '10:00',
                'status' => 'completed',
                'notes' => 'Treatment completed. Recommended calming serum.',
            ],
            [
                'customer' => 'Emma Brown',
                'service' => 'Swedish Relaxation Massage',
                'staff' => 'Noah Davis',
                'date' => now()->subDays(5)->toDateString(),
                'time' => '16:00',
                'status' => 'completed',
                'notes' => 'Booked follow-up in four weeks.',
            ],
            [
                'customer' => 'James Walker',
                'service' => 'Business Strategy Session',
                'staff' => 'Daniel King',
                'date' => now()->subDays(10)->toDateString(),
                'time' => '15:00',
                'status' => 'completed',
                'notes' => 'Sent post-session action plan.',
            ],
            [
                'customer' => 'Olivia Martinez',
                'service' => 'Skin Analysis Appointment',
                'staff' => 'Grace Lee',
                'date' => now()->subDays(12)->toDateString(),
                'time' => '09:30',
                'status' => 'cancelled',
                'notes' => 'Client cancelled due to schedule conflict.',
            ],
            [
                'customer' => 'Lily Thompson',
                'service' => 'Brow Shaping & Tint',
                'staff' => 'Isabella Miller',
                'date' => now()->addDays(10)->toDateString(),
                'time' => '09:30',
                'status' => 'pending',
                'notes' => 'Add-on service before event styling.',
            ],
        ];

        foreach ($appointments as $appointment) {
            Appointment::create([
                'customer_id' => Customer::where('full_name', $appointment['customer'])->value('id'),
                'service_id' => Service::where('name', $appointment['service'])->value('id'),
                'staff_id' => Staff::where('name', $appointment['staff'])->value('id'),
                'appointment_date' => $appointment['date'],
                'appointment_time' => $appointment['time'],
                'status' => $appointment['status'],
                'notes' => $appointment['notes'],
            ]);
        }
    }
}
