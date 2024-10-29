<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use Barryvdh\DomPDF\Facade\Pdf;


class PDFController extends Controller
{
    public function generatePDF($id_tagihan)
    {
        $tagihan = Tagihan::with(['mahasiswa', 'semester'])->where('id_tagihan', $id_tagihan)->first();

        if (!$tagihan) {
            return redirect()->back()->with('error', 'Tagihan not found.');
        }

        $data = [
            'title' => 'BuktiPembayaran-' . $tagihan->mahasiswa->nama . '-' . $tagihan->semester->nama_semester,
            'id_tagihan' => $tagihan->id_tagihan,
            'nama' => $tagihan->mahasiswa->nama,
            'NIM' => $tagihan->NIM,
            'total_tagihan' => $tagihan->total_tagihan,
            'id_semester' => $tagihan->semester->nama_semester,
            'total_bayar' => $tagihan->total_bayar,
            'status_tagihan' => $tagihan->status_tagihan,
        ];

        // Load the view and pass data to it, then generate the PDF
        $pdf = Pdf::loadView('livewire.mahasiswa.keuangan.download', $data)->setPaper('a4', 'landscape');

        // Return the generated PDF file as a response for download
        return $pdf->stream('BuktiPembayaran-' . $tagihan->mahasiswa->nama . '-' . $tagihan->semester->nama_semester . '.pdf');
    }
}
