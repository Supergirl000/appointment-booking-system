<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'full_name' => 'Ava Johnson',
                'phone' => '+1 555 0101',
                'email' => 'ava.johnson@example.com',
                'notes' => 'Prefers morning appointments and fragrance-free skin care products.',
            ],
            [
                'full_name' => 'Mia Carter',
                'phone' => '+1 555 0102',
                'email' => 'mia.carter@example.com',
                'notes' => 'Sensitive skin noted for facial treatments. Avoid strong exfoliants.',
            ],
            [
                'full_name' => 'Sophia Williams',
                'phone' => '+1 555 0103',
                'email' => 'sophia.williams@example.com',
                'notes' => 'Books manicure appointments every three weeks.',
            ],
            [
                'full_name' => 'Emma Brown',
                'phone' => '+1 555 0104',
                'email' => 'emma.brown@example.com',
                'notes' => 'Usually books on weekends.',
            ],
            [
                'full_name' => 'Noah Anderson',
                'phone' => '+1 555 0105',
                'email' => 'noah.anderson@example.com',
                'notes' => 'Interested in recurring deep tissue therapy after sports training.',
            ],
            [
                'full_name' => 'Olivia Martinez',
                'phone' => '+1 555 0106',
                'email' => 'olivia.martinez@example.com',
                'notes' => 'Clinic client. Requested wellness follow-up after initial consultation.',
            ],
            [
                'full_name' => 'Ethan Brooks',
                'phone' => '+1 555 0107',
                'email' => 'ethan.brooks@example.com',
                'notes' => 'Consulting lead for a small wellness studio.',
            ],
            [
                'full_name' => 'Lily Thompson',
                'phone' => '+1 555 0108',
                'email' => 'lily.thompson@example.com',
                'notes' => 'Bridal client. Needs event hair styling and nail services.',
            ],
            [
                'full_name' => 'James Walker',
                'phone' => '+1 555 0109',
                'email' => 'james.walker@example.com',
                'notes' => 'Prefers late afternoon consulting appointments.',
            ],
            [
                'full_name' => 'Amelia Scott',
                'phone' => '+1 555 0110',
                'email' => 'amelia.scott@example.com',
                'notes' => 'Interested in monthly facial membership.',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::updateOrCreate(
                ['email' => $customer['email']],
                $customer
            );
        }
    }
}
