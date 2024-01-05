<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name' => 'admin', 'email' => 'admin@gmail.com', 'password' => 'admin', 'role' => 'Admin']);
        User::create(['name' => 'fajar', 'email' => 'fajar@gmail.com', 'password' => 'fajar', 'role' => 'Customer']);
        User::create(['name' => 'naufal', 'email' => 'naufal@gmail.com', 'password' => 'naufal', 'role' => 'Customer']);
        User::create(['name' => 'kuswanto', 'email' => 'kuswanto@gmail.com', 'password' => 'kuswanto', 'role' => 'Customer']);
        User::create(['name' => 'superadmin','email' => 'superadmin@gmail.com','password' => 'superadmin','role'=> 'Superadmin']);
    }
}
