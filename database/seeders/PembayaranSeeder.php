<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Tagihan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswaList = Mahasiswa::orderByDesc('NIM')->limit(30)->get();

        foreach ($mahasiswaList as $index => $mahasiswa) {
            try {

                // Half 'Lunas', half 'Belum Lunas'
                $statusTagihan = ($index % 2 === 0) ? 'Lunas' : 'Belum Lunas';
                $totalBayar = ($statusTagihan === 'Lunas') ? 3000000 : 1500000;

                // Create Tagihan for semester 6
                Tagihan::create([
                    'NIM' => $mahasiswa->NIM,
                    'total_tagihan' => 3000000,
                    'status_tagihan' => $statusTagihan,
                    'id_semester' => 6,
                    'Bulan' => '2025-02',
                    'total_bayar' => $totalBayar,
                    'id_staff' => 1,
                    'metode_pembayaran' => 'Midtrans Payment',
                    'jenis_tagihan' => 'aaaa',
                    'no_kwitansi' => rand(),
                ]);

                // Create Tagihan for semester 5 (always Lunas)
                Tagihan::create([
                    'NIM' => $mahasiswa->NIM,
                    'total_tagihan' => 3000000,
                    'status_tagihan' => 'Lunas',
                    'id_semester' => 5,
                    'Bulan' => '2025-02',
                    'total_bayar' => 3000000,
                    'id_staff' => 1,
                    'metode_pembayaran' => 'Midtrans Payment',
                    'jenis_tagihan' => 'aaaa',
                    'no_kwitansi' => rand(),
                ]);

                echo "Created Tagihan for NIM: {$mahasiswa->NIM}\n";
            } catch (\Exception $e) {
                echo "Error processing NIM: {$mahasiswa->NIM}. Error: " . $e->getMessage() . "\n";
            }
        }
    }
}
