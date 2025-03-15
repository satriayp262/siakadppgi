<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnggotaKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswaList = Mahasiswa::orderBy('NIM', 'desc')->get();

        // Define which NIMs go to Kelas A or Kelas B
        $kelasA_NIM = ['9999999991', '9999999999', '9999999995', '9999999996', '9999999911', '9999999912', '9999999916', '9999999917'];
        $kelasB_NIM = ['9999999992', '9999999993', '9999999994', '9999999910', '9999999997', '9999999998', '9999999913', '9999999914', '9999999915', '9999999918', '9999999919', '9999999920'];

        foreach ($mahasiswaList as $mahasiswa) {
            $kelasA = Kelas::where(function ($query) {
                $query->where('nama_kelas', 'LIKE', 'A%')
                    ->orWhere('nama_kelas', 'LIKE', 'a%');
            })
                ->where('kode_prodi', $mahasiswa->kode_prodi)
                ->first();

            $kelasB = Kelas::where(function ($query) {
                $query->where('nama_kelas', 'LIKE', 'B%')
                    ->orWhere('nama_kelas', 'LIKE', 'b%');
            })
                ->where('kode_prodi', $mahasiswa->kode_prodi)
                ->first();


            $nim = (string) $mahasiswa->NIM;

            if (in_array($nim, $kelasA_NIM)) {
                $mahasiswa->update(['id_kelas' => $kelasA->id_kelas]);
                echo "{$mahasiswa->NIM} di kelas $kelasA->nama_kelas\n";
            } elseif (in_array($nim, $kelasB_NIM)) {
                $mahasiswa->update(['id_kelas' => $kelasB->id_kelas]);
                echo "{$mahasiswa->NIM} di kelas $kelasB->nama_kelas\n";
            } else {
                if (rand(0, 1) === 0) {
                    $mahasiswa->update(['id_kelas' => $kelasA->id_kelas]);
                    echo "{$mahasiswa->NIM} di kelas $kelasA->nama_kelas\n";
                } else {
                    $mahasiswa->update(['id_kelas' => $kelasB->id_kelas]);
                    echo "{$mahasiswa->NIM} di kelas $kelasB->nama_kelas\n";
                }
            }
        }

        echo "Done";


    }
}
