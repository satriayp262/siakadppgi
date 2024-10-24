<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use Barryvdh\DomPDF\Facade\Pdf;


class PDFController extends Controller
{
    public function mount($id_tagihan)
    {
        $tagihan = Tagihan::find($id_tagihan);
        if ($tagihan) {
            $this->id_tagihan = $tagihan->id_tagihan;
            $this->NIM = $tagihan->NIM;
            $this->total_tagihan = $tagihan->total_tagihan;
            $this->id_semester = $tagihan->semester->nama_semester;
            $this->total_bayar = $tagihan->total_bayar;
            $this->status_tagihan = $tagihan->status_tagihan;
        }
    }

    public function generatePDF($id_tagihan)
    {
        $tagihan = Tagihan::with(['mahasiswa', 'semester'])->where('id_tagihan', $id_tagihan)->first();

        if (!$tagihan) {
            return redirect()->back()->with('error', 'Tagihan not found.');
        }

        $data = [
            'id_tagihan' => $tagihan->id_tagihan,
            'nama' => $tagihan->mahasiswa->nama,
            'NIM' => $tagihan->NIM,
            'total_tagihan' => $tagihan->total_tagihan,
            'id_semester' => $tagihan->semester->nama_semester,
            'total_bayar' => $tagihan->total_bayar,
            'status_tagihan' => $tagihan->status_tagihan,
        ];



        // Load the view and pass data to it, then generate the PDF
        $pdf = Pdf::loadView('livewire.mahasiswa.keuangan.download', $data);

        // Return the generated PDF file as a response for download
        return $pdf->download('BuktiPembayaran-' . $tagihan->mahasiswa->nama . '-' . $tagihan->semester->nama_semester . '.pdf');
    }
}
