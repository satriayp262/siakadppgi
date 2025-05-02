<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use App\Models\Cicilan_BPP;
use App\Models\Mahasiswa;
use App\Models\Semester;
use App\Models\Tagihan;
use App\Models\Konfirmasi_Pembayaran;
use Livewire\Component;
use Livewire\WithFileUploads;

class Konfirmasi extends Component
{
    public $bukti;
    public $jumlah_pembayaran;
    public $tanggal_pembayaran;
    public $id_tagihan = '';
    public $nim;

    use WithFileUploads;

    public function rules()
    {
        return [
            'id_tagihan' => 'required|exists:tagihan,id_tagihan',
            'bukti' => 'required|image|max:2048',
            'tanggal_pembayaran' => 'required|date',
            'jumlah_pembayaran' => 'required|numeric|min:0',
        ];
    }
    public function messages()
    {
        return [
            'id_tagihan.required' => 'Tagihan tidak boleh kosong',
            'id_tagihan.exists' => 'Tagihan tidak ditemukan',
            'bukti.required' => 'Bukti pembayaran tidak boleh kosong',
            'bukti.image' => 'File harus berupa gambar',
            'bukti.max' => 'Ukuran file maksimal 2MB',
            'tanggal_pembayaran.required' => 'Tanggal pembayaran tidak boleh kosong',
            'tanggal_pembayaran.date' => 'Format tanggal tidak valid',
            'jumlah_pembayaran.required' => 'Jumlah pembayaran tidak boleh kosong',
            'jumlah_pembayaran.numeric' => 'Jumlah pembayaran harus berupa angka',
            'jumlah_pembayaran.min' => 'Jumlah pembayaran tidak boleh negatif',
        ];
    }

    public function listbulan()
    {
        $semester = Semester::where('nama_semester', $this->id_semester)->first();
        $awalbulan = $semester->bulan_mulai;
        $akhirbulan = $semester->bulan_selesai;

        $bulan1 = (int) substr($awalbulan, 5, 2);
        $bulan2 = (int) substr($akhirbulan, 5, 2);
        $tahun1 = (int) substr($awalbulan, 0, 4);
        $tahun2 = (int) substr($akhirbulan, 0, 4);

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $dropdown = [];

        // Tangani jika beda tahun (misal: Nov 2024 - Feb 2025)
        if ($tahun1 == $tahun2) {
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $dropdown[] = $namaBulan[$i] . ' ' . $tahun1;
            }
        } else {
            // Tahun pertama
            for ($i = $bulan1; $i <= 12; $i++) {
                $dropdown[] = $namaBulan[$i] . ' ' . $tahun1;
            }
            // Tahun kedua
            for ($i = 1; $i <= $bulan2; $i++) {
                $dropdown[] = $namaBulan[$i] . ' ' . $tahun2;
            }
        }

        //cek apakah sudah ada di cicilan
        $cicilan = Cicilan_BPP::where('id_tagihan', $this->id_tagihan)->get();
        $bulancicilan = [];

        foreach ($cicilan as $item) {
            $bulancicilan[] = $item->bulan;
        }

        $dropdown = array_diff($dropdown, $bulancicilan);

        return $dropdown;
    }

    public function save()
    {

        $this->jumlah_pembayaran = str_replace(['.', ','], '', $this->jumlah_pembayaran);


        $validatedData = $this->validate();



        //Search Apakah Sudah ada konfirmasi pembayaran


        $x = Konfirmasi_Pembayaran::where('id_tagihan', $this->id_tagihan)
            ->where('status', 'Menunggu Konfirmasi')
            ->first();


        if ($x) {
            $this->dispatch('warning', ['message' => 'Tagihan Sudah Ada Konfirmasi Pembayaran']);
            return;
        }

        $nim = auth()->user()->nim_nidn;

        $imageName = 'konfirmasi_pembayaran_' . $nim . '_' . time() . '.' . $this->bukti->extension();

        $this->bukti->storeAs('public/image/bukti_pembayaran', $imageName);

        $konfirmasi = Konfirmasi_Pembayaran::create([
            'id_tagihan' => $this->id_tagihan,
            'bukti_pembayaran' => $imageName,
            'NIM' => auth()->user()->nim_nidn,
            'jumlah_pembayaran' => $validatedData['jumlah_pembayaran'],
            'status' => 'Menunggu Konfirmasi',
            'tanggal_pembayaran' => $validatedData['tanggal_pembayaran'],
        ]);

        $konfirmasi->save();

        $this->reset();

        $this->dispatch('created', ['message' => 'Pembayaran Berhasil di Tambahkan']);

        return $konfirmasi;

    }

    public function render()
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('nim', $user->nim_nidn)->first();

        $tagihan = Tagihan::with('semester')
            ->where('NIM', $mahasiswa->NIM)
            ->where('status_tagihan', '!=', 'Lunas')
            ->get();

        $cicilan = Cicilan_BPP::where('id_tagihan', $this->id_tagihan)
            ->get();

        return view('livewire.mahasiswa.keuangan.konfirmasi', [
            'tagihan' => $tagihan,
            'mahasiswa' => $mahasiswa,
        ]);
    }
}
