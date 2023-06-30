<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
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
//        UserFactory::times(10)->create();
        User::create([
            "name" => "ahmet Turan",
            "email" => "akio@msn.com",
            "email_verified_at" => null,
            "password" => bcrypt("12345678"),
            "is_admin" => 1,
            "status" => 1,
            "agreement"=> 1,
        ]);
        User::create([
            "name" => "Demo User",
            "email" => "demo@demo.com",
            "email_verified_at" => null,
            "password" => bcrypt("12345678"),
            "is_admin" => 0,
            "status" => 1,
            "agreement"=> 1,
        ]);
    }
}
