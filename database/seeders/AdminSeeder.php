<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => '123@gmail.com',
            'password' => '11111111',
            'role' => 'admin',
        ]);
    }
}