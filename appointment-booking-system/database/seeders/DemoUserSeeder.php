<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $demoAdmin = User::updateOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Demo Admin',
            'password' => Hash::make('password'),
        ]);

        $demoAdmin->forceFill([
            'email_verified_at' => now(),
        ])->save();
    }
}
