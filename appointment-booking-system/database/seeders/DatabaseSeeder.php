<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PrivateAdminSeeder::class,
            DemoUserSeeder::class,
            ServicesSeeder::class,
            CustomersSeeder::class,
            StaffSeeder::class,
            AppointmentsSeeder::class,
            SettingsSeeder::class,
        ]);
    }
}
