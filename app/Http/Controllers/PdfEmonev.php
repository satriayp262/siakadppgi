<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfEmonev extends Controller
{
    protected $jawaban;

    public function generatePDF()
    {

        $jawaban = collect(session('jawaban'));

        $pdf = PDF::loadView('livewire.admin.emonev.download', compact('jawaban'))->setPaper('A4', 'potrait');

        return $pdf->stream('emonev.pdf');

    }
}
