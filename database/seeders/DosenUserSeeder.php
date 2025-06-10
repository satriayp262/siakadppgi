<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DosenUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosenList = Dosen::all();

foreach ($dosenList as $dosen) {
    try {

        // Check if the user already exists
        $existingUser = User::where('nim_nidn', $dosen->nidn)->first();
        if ($existingUser) {
            echo "User already exists for NIDN: {$dosen->nidn}\n";
            continue;
        }

        // Get the first word of the name
        $firstWord = explode(' ', trim($dosen->nama_dosen))[0];

        // Generate a default email using only the first word
        $email = strtolower($firstWord.rand(10,99)) . '@example.com';

        // Create the user
        $user = User::create([
            'name' => $dosen->nama_dosen,
            'email' => $email,
            'nim_nidn' => $dosen->nidn,
            'password' => Hash::make($email), // Default password
            'role' => 'dosen',
        ]);

    } catch (\Exception $e) {
        echo "Error processing Dosen ID: {$dosen->id_dosen}. Error: " . $e->getMessage() . "\n";
    }
}
    }
}
