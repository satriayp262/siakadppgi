<?php

namespace App\Livewire\Dosen\Jadwal;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Preferensi_jadwal;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class Index extends Component
{

    public $dosen;
    public $hari;
    public $waktu;

    public function mount()
    {
        $this->dosen = Dosen::where('nidn', Auth()->user()->nim_nidn)->first();
    }

    public function generatePdf()
    {
        $dosen = Dosen::where('nidn', Auth()->user()->nim_nidn)->first();

        $jadwals = Jadwal::whereHas('kelas.krs.mahasiswa', function ($query) use ($dosen) {
            $query->where('nidn', $dosen->nidn);
        })
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('sesi')  // Urutkan berdasarkan sesi
            ->get();

        $x = $jadwals->first();

        $data = [
            'jadwals' => $jadwals,
            'x' => $x
        ];

        $pdf = PDF::loadView('livewire.dosen.jadwal.download', $data);


        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Jadwal Mengajar Dosen ' . $dosen->nama_dosen . ' Semester ' . $jadwals[0]->semester->nama_semester . '.pdf');
    }

    public function preferensi()
    {
        // Validasi input
        $this->validate([
            'hari' => 'required',
            'waktu' => 'required',
        ], [
            'hari.required' => 'Hari wajib dipilih.',
            'waktu.required' => 'Waktu wajib dipilih.',
        ]);

        $cek = Preferensi_jadwal::where('nidn', $this->dosen->nidn)->first();

        if ($cek) {
            Preferensi_jadwal::where('id_preferensi', $cek->id_preferensi)->update([
                'nidn' => $this->dosen->nidn,
                'hari' => $this->hari != '' ? $this->hari : $cek->hari,
                'waktu' => $this->waktu != '' ? $this->waktu : $cek->waktu
            ]);

            $this->dispatch('show-message', type: 'success', message: 'Preferensi Berhasil Diubah');
        } else {
            Preferensi_jadwal::create([
                'nidn' => $this->dosen->nidn,
                'hari' => $this->hari,
                'waktu' => $this->waktu,
            ]);

            $this->dispatch('show-message', type: 'success', message: 'Preferensi Berhasil Dibuat');
        }
    }


    public function render()
    {
        $bulanMulai = null;
        $bulanSelesai = null;

        $dosen = Dosen::where('nidn', Auth()->user()->nim_nidn)->first();

        $jadwals = Jadwal::whereHas('kelas.krs.mahasiswa', function ($query) use ($dosen) {
            $query->where('nidn', $dosen->nidn);
        })
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('sesi')
            ->get();

        $preferensi = Preferensi_jadwal::where('nidn', $dosen->nidn)->first();

        $jadwal = $jadwals->first();

        if ($jadwal) {
            \Carbon\Carbon::setLocale('id');

            $bulanMulai = \Carbon\Carbon::parse($jadwal->semester->bulan_mulai)->translatedFormat('F Y');
            $bulanSelesai = \Carbon\Carbon::parse($jadwal->semester->bulan_selesai)->translatedFormat('F Y');
        }

        return view('livewire.dosen.jadwal.index',[
            'jadwals' => $jadwals,
            'preferensi' => $preferensi,
            'bulanMulai' => $bulanMulai,
            'bulanSelesai' => $bulanSelesai
        ]);
    }
}
