<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use Livewire\Component;
use App\Models\Tagihan;
use App\Models\Cicilan_BPP;
use App\Models\Semester;
use App\Models\Transaksi;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Cicil extends Component
{
    public $NIM;
    public $jenis_tagihan;
    public $total_tagihan;
    public $total_bayar;
    public $id_semester;
    public $tagihan;
    public $id_tagihan;
    public $bulan = '';
    public $tanggal_pembayaran;
    public $status_tagihan = '';
    public $id_staff = '';


    public function mount()
    {
        $this->tagihan = Tagihan::find($this->id_tagihan);
        $hitung_cicilan = Cicilan_BPP::where('id_tagihan', $this->id_tagihan)->count();

        $user = auth()->user();
        $this->id_staff = $user->nim_nidn;

        if ($this->tagihan) {
            $this->NIM = $this->tagihan->mahasiswa->NIM;
            $this->jenis_tagihan = $this->tagihan->jenis_tagihan;
            $this->total_tagihan = $this->tagihan->total_tagihan;
            $this->id_semester = $this->tagihan->semester->nama_semester;
            $this->status_tagihan = $this->tagihan->status_tagihan;
        }
        $total = $this->total_tagihan;
        $this->listbulan = $this->listbulan();

        $hitung_bulan = count($this->listbulan);
        $cicil = round($total / 6, -3);

        //untuk pembuatan cicilan
        if ($cicil * $hitung_bulan < $total) {
            $cicil = $cicil + 500;
            if ($hitung_cicilan > 4) {
                $cicil = $total - ($cicil * ($hitung_bulan - 1));
            }
        }

        $this->total_bayar = $cicil;


    }
    public function rules()
    {
        return [
            'bulan' => 'required',
            'total_bayar' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'total_bayar.required' => 'Total bayar tidak boleh kosong',
            'total_bayar.numeric' => 'Total bayar harus berupa angka',
            'bulan.required' => 'Bulan tidak boleh kosong',
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

    public function update()
    {
        $this->validate();

        $nominal = $this->total_bayar;

        $tagihan = Tagihan::find($this->id_tagihan);
        $tagihan->metode_pembayaran = 'Cicilan';
        $tagihan->save();

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $order_id = 'ORDER - ' . rand();

        // Pastikan order_id unik
        while (Transaksi::where('order_id', $order_id)->exists()) {
            $order_id = 'ORDER - ' . rand();
        }

        $transaksi = Transaksi::create([
            'id_transaksi' => (string) Str::uuid(),
            'nominal' => $nominal + 5000, // Tambahkan biaya admin
            'NIM' => $tagihan->NIM,
            'id_tagihan' => $this->id_tagihan,
            'status' => 'pending',
            'snap_token' => null,
            'order_id' => $order_id,
            'bulan' => $this->bulan,
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $nominal + 5000,
            ],
            'customer_details' => [
                'first_name' => $tagihan->mahasiswa->nama,
                'email' => $tagihan->mahasiswa->email,
                'phone' => $tagihan->mahasiswa->no_hp,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        $transaksi->snap_token = $snapToken;
        $transaksi->save();

        // Redirect ke halaman transaksi
        return redirect()->route('mahasiswa.transaksi', [
            'order_id' => $order_id,
        ]);


    }
    public function render()
    {
        return view('livewire.mahasiswa.keuangan.cicil', [
            'listbulan' => $this->listbulan,
        ]);
    }
}
