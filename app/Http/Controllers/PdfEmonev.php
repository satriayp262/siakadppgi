<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfEmonev extends Controller
{
    protected $jawaban;

    public function generatePDF()
    {

        $jawaban = collect(session('jawaban'));

        $pertanyaan = Pertanyaan::all();

        $imagePath = "img/kop_surat.jpg"; // Adjust path based on your storage
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageBase64 = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;

        $pdf = PDF::loadView('livewire.admin.emonev.download', compact('jawaban', 'pertanyaan', 'imageBase64'))->setPaper('A4', 'landscape');

        return $pdf->stream('emonev.pdf');

    }
}
