<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => '',
            'email' => 'admin123@blogify.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'address' => '',
            'phone' => '',
            'password' => Hash::make('admin123'),
        ]);
        $user->assignRole('super-admin');
    }
}
