<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Signature Glow Facial',
                'category' => 'Skin Care',
                'duration_minutes' => 60,
                'price' => 85.00,
                'description' => 'A brightening facial with cleanse, exfoliation, serum infusion, mask, and hydration finish.',
                'status' => 'active',
            ],
            [
                'name' => 'Swedish Relaxation Massage',
                'category' => 'Spa',
                'duration_minutes' => 75,
                'price' => 110.00,
                'description' => 'A full-body spa massage focused on easing tension and improving relaxation.',
                'status' => 'active',
            ],
            [
                'name' => 'Luxury Gel Manicure',
                'category' => 'Beauty Salon',
                'duration_minutes' => 45,
                'price' => 45.00,
                'description' => 'Nail shaping, cuticle care, hand massage, and long-wear gel polish.',
                'status' => 'active',
            ],
            [
                'name' => 'Event Hair Styling',
                'category' => 'Beauty Salon',
                'duration_minutes' => 50,
                'price' => 70.00,
                'description' => 'Professional wash, blow-dry, and styling for events, shoots, or special occasions.',
                'status' => 'active',
            ],
            [
                'name' => 'Brow Shaping & Tint',
                'category' => 'Beauty Salon',
                'duration_minutes' => 25,
                'price' => 30.00,
                'description' => 'Precision brow shaping, tint, and finishing for a polished look.',
                'status' => 'active',
            ],
            [
                'name' => 'Deep Tissue Therapy',
                'category' => 'Spa',
                'duration_minutes' => 90,
                'price' => 140.00,
                'description' => 'Therapeutic massage for deeper muscle tension, posture strain, and recovery support.',
                'status' => 'active',
            ],
            [
                'name' => 'Wellness Consultation',
                'category' => 'Clinic',
                'duration_minutes' => 40,
                'price' => 95.00,
                'description' => 'A private consultation for wellness goals, treatment planning, and lifestyle recommendations.',
                'status' => 'active',
            ],
            [
                'name' => 'Skin Analysis Appointment',
                'category' => 'Clinic',
                'duration_minutes' => 30,
                'price' => 65.00,
                'description' => 'Professional skin assessment with product and treatment guidance.',
                'status' => 'active',
            ],
            [
                'name' => 'Business Strategy Session',
                'category' => 'Consulting',
                'duration_minutes' => 60,
                'price' => 180.00,
                'description' => 'One-on-one consulting session for service businesses improving operations or client experience.',
                'status' => 'active',
            ],
            [
                'name' => 'Team Operations Review',
                'category' => 'Consulting',
                'duration_minutes' => 120,
                'price' => 320.00,
                'description' => 'A structured review session for bookings, staffing, and process improvement.',
                'status' => 'inactive',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['name' => $service['name']],
                $service
            );
        }
    }
}
