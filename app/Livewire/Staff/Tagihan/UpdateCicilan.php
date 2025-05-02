<?php

namespace App\Livewire\Staff\Tagihan;

use App\Models\Cicilan_BPP;
use Livewire\Component;
use App\Models\Tagihan;
use App\Models\Semester;
use App\Models\Mahasiswa;
use App\Models\Staff;
use Illuminate\Support\Facades\Mail;

class UpdateCicilan extends Component
{
    public $NIM;
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
            $this->total_tagihan = $this->tagihan->total_tagihan;
            $this->id_semester = $this->tagihan->semester->nama_semester;
            $this->status_tagihan = $this->tagihan->status_tagihan;
        }

        $total = $this->total_tagihan;
        $this->listbulan = $this->listbulan();

        $hitung_bulan = count($this->listbulan);
        $cicil = round($total / $hitung_bulan, -3);

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
            'tanggal_pembayaran' => 'required|date',
            'bulan' => 'required',
            'total_bayar' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'tanggal_pembayaran.required' => 'Tanggal pembayaran tidak boleh kosong',
            'tanggal_pembayaran.date' => 'Tanggal pembayaran harus berupa tanggal yang valid',
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

    public function save()
    {
        $validatedata = $this->validate();

        $s = Cicilan_BPP::where('id_tagihan', $this->id_tagihan)->count();
        $count_cicilan = $s + 1;

        $tagihan = Tagihan::find($this->id_tagihan);
        $tagihan->total_bayar = $tagihan->total_bayar + $validatedata['total_bayar'];
        $tagihan->metode_pembayaran = 'Cicilan';

        if ($tagihan->total_bayar >= $tagihan->total_tagihan) {
            $tagihan->status_tagihan = 'Lunas';
            $tagihan->id_staff = $this->id_staff;
            if ($tagihan->id_staff == null) {
                dd('Staff tidak ada');
            }
            $tagihan->no_kwitansi = rand();
            while (Tagihan::where('no_kwitansi', $tagihan->no_kwitansi)->exists()) {
                $tagihan->no_kwitansi = rand();
            }
        } else {
            $tagihan->status_tagihan = 'Belum Lunas';
        }

        $tagihan->save();

        $cicilan = Cicilan_BPP::create([
            'id_tagihan' => $this->id_tagihan,
            'jumlah_bayar' => $validatedata['total_bayar'],
            'tanggal_bayar' => $validatedata['tanggal_pembayaran'],
            'cicilan_ke' => $count_cicilan,
            'bulan' => $validatedata['bulan'],
            'metode_pembayaran' => 'Tunai',
        ]);

        $cicilan->save();

        $this->reset(['total_bayar', 'tanggal_pembayaran']);

        $this->dispatch('created', [
            'message' => 'Data Pembayaran berhasil disimpan',
        ]);

        return redirect()->route('staff.detail', ['NIM' => $this->NIM]);
    }
    public function render()
    {
        return view('livewire.staff.tagihan.update-cicilan', [
            'listbulan' => $this->listbulan,
        ]);
    }
}
