<?php

namespace App\Http\Controllers;

use App\Models\KHS;
use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\Semester;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KHSController extends Controller
{
    public function generatePDF($NIM, $id_semester)
    {
        if (!session()->has('IPK')) {
            abort(403, 'Unauthorized access');
        }

        $mahasiswa = Mahasiswa::where('NIM', $NIM)->firstOrFail();
        $khs = KRS::where('id_semester', $id_semester)
            ->where('NIM', $NIM)
            ->with('khs')
            ->get()
            ->pluck('khs');
        $x = Semester::findOrFail($id_semester);
        $IPK = session('IPK');
        $pdf = Pdf::loadView('livewire.khs.download', compact('x', 'khs', 'mahasiswa', 'IPK'))->setPaper('A4', 'portrait');
        return $pdf->download('KHS ' . $mahasiswa->NIM . ' Semester ' . $mahasiswa->getSemester($id_semester) . '.pdf');
    }
    public function rekap($NIM)
    {
        $mahasiswa = Mahasiswa::where('NIM', $NIM)->firstOrFail();
        $khs = KRS::where('NIM', $NIM)
            ->with('khs.krs.matkul')
            ->get()
            ->pluck('khs')
            ->flatten()
            ->filter()
            ->groupBy(fn($item) => $item->matkul?->kode_mata_kuliah)
            ->map(fn($group) => $group->sortByDesc('bobot')->first())
            ->values();

        $pdf = Pdf::loadView('livewire.khs.rekap', compact('khs', 'mahasiswa'))->setPaper('A4', 'portrait');
        return $pdf->download('KHS ' . $mahasiswa->NIM . '  ' . $mahasiswa->nama . '.pdf');
    }
}
