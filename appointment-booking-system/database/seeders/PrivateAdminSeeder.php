<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PrivateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = env('PRIVATE_ADMIN_NAME', 'RugosTech Admin');
        $email = env('PRIVATE_ADMIN_EMAIL');
        $password = env('PRIVATE_ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command?->warn('Private admin skipped. Set PRIVATE_ADMIN_EMAIL and PRIVATE_ADMIN_PASSWORD in .env to create it.');

            return;
        }

        Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ])->validate();

        User::updateOrCreate([
            'email' => $email,
        ], [
            'name' => $name,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
            'is_demo' => false,
        ]);
    }
}