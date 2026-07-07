<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffMembers = [
            [
                'name' => 'Olivia Smith',
                'phone' => '+1 555 0201',
                'email' => 'olivia.smith@example.com',
                'role' => 'Senior Hair Stylist',
                'status' => 'active',
            ],
            [
                'name' => 'Noah Davis',
                'phone' => '+1 555 0202',
                'email' => 'noah.davis@example.com',
                'role' => 'Spa Massage Therapist',
                'status' => 'active',
            ],
            [
                'name' => 'Isabella Miller',
                'phone' => '+1 555 0203',
                'email' => 'isabella.miller@example.com',
                'role' => 'Nail Technician',
                'status' => 'active',
            ],
            [
                'name' => 'Lucas Wilson',
                'phone' => '+1 555 0204',
                'email' => 'lucas.wilson@example.com',
                'role' => 'Front Desk Coordinator',
                'status' => 'active',
            ],
            [
                'name' => 'Grace Lee',
                'phone' => '+1 555 0205',
                'email' => 'grace.lee@example.com',
                'role' => 'Aesthetic Nurse',
                'status' => 'active',
            ],
            [
                'name' => 'Daniel King',
                'phone' => '+1 555 0206',
                'email' => 'daniel.king@example.com',
                'role' => 'Business Consultant',
                'status' => 'active',
            ],
            [
                'name' => 'Harper Young',
                'phone' => '+1 555 0207',
                'email' => 'harper.young@example.com',
                'role' => 'Junior Beauty Assistant',
                'status' => 'inactive',
            ],
        ];

        foreach ($staffMembers as $staff) {
            Staff::updateOrCreate(
                ['email' => $staff['email']],
                $staff
            );
        }
    }
}
