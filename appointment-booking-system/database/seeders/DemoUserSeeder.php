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
            'email' => 'demo@lumiere.com',
        ], [
            'name' => 'Demo Admin',
            'password' => Hash::make('demo123'),
            'is_demo' => true,
        ]);

        $demoAdmin->forceFill([
            'email_verified_at' => now(),
            'is_demo' => true,
        ])->save();
    }
}
