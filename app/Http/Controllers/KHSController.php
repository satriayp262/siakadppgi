<?php

namespace App\Http\Controllers;

use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\Semester;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KHSController extends Controller
{
    public function generatePDF($NIM,$id_semester,$IndexKumulatif)
    {
        $mahasiswa = Mahasiswa::where('NIM', $NIM)->firstOrFail();
        $khs = KHS::where('id_semester', $id_semester)->where('NIM', $NIM)->get();
        $x = Semester::findOrFail($id_semester);
        $IPK = $IndexKumulatif;
        $pdf = Pdf::loadView('livewire.khs.download', compact('x', 'khs', 'mahasiswa','IPK'))->setPaper('A4', 'portrait');
        return $pdf->stream('KHS_' . $mahasiswa->NIM .' Semester'.$mahasiswa->getSemesterDifferenceAttribute() .'.pdf');
    }
}
