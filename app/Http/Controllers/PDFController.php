<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use Barryvdh\DomPDF\Facade\Pdf;


class PDFController extends Controller
{

    private function terbilang($number)
    {
        // Remove any non-numeric characters (e.g., currency symbols, commas, periods)
        $number = preg_replace('/[^0-9]/', '', $number);
        $number = abs((int) $number);

        if ($number == 0) {
            return "nol";
        }

        $words = array(
            "",
            "SATU",
            "DUA",
            "TIGA",
            "EMPAT",
            "LIMA",
            "ENAM",
            "TUJUH",
            "DELAPAN",
            "SEMBILAN",
            "SEPULUH",
            "SEBELAS",
            "DUA BELAS",
            "TIGA BELAS",
            "EMPAT BELAS",
            "LIMA BELAS",
            "ENAM BELAS",
            "TUJUH BELAS",
            "DELAPAN BELAS",
            "SEMBILAN BELAS",
            "DUA PULUH",
            "DUA PULUH SATU",
            "DUA PULUH DUA",
            "DUA PULUH TIGA",
            "DUA PULUH EMPAT",
            "DUA PULUH LIMA",
            "DUA PULUH ENAM",
            "DUA PULUH TUJUH",
            "DUA PULUH DELAPAN",
            "DUA PULUH SEMBILAN",
            "TIGA PULUH",
            "TIGA PULUH SATU",
            "TIGA PULUH DUA",
            "TIGA PULUH TIGA",
            "TIGA PULUH EMPAT",
            "TIGA PULUH LIMA",
            "TIGA PULUH ENAM",
            "TIGA PULUH TUJUH",
            "TIGA PULUH DELAPAN",
            "TIGA PULUH SEMBILAN",
            "EMPAT PULUH",
            "EMPAT PULUH SATU",
            "EMPAT PULUH DUA",
            "EMPAT PULUH TIGA",
            "EMPAT PULUH EMPAT",
            "EMPAT PULUH LIMA",
            "EMPAT PULUH ENAM",
            "EMPAT PULUH TUJUH",
            "EMPAT PULUH DELAPAN",
            "EMPAT PULUH SEMBILAN",
            "LIMA PULUH",
            "LIMA PULUH SATU",
            "LIMA PULUH DUA",
            "LIMA PULUH TIGA",
            "LIMA PULUH EMPAT",
            "LIMA PULUH LIMA",
            "LIMA PULUH ENAM",
            "LIMA PULUH TUJUH",
            "LIMA PULUH DELAPAN",
            "LIMA PULUH SEMBILAN",
            "ENAM PULUH",
            "ENAM PULUH SATU",
            "ENAM PULUH DUA",
            "ENAM PULUH TIGA",
            "ENAM PULUH EMPAT",
            "ENAM PULUH LIMA",
            "ENAM PULUH ENAM",
            "ENAM PULUH TUJUH",
            "ENAM PULUH DELAPAN",
            "ENAM PULUH SEMBILAN",
            "TUJUH PULUH",
            "TUJUH PULUH SATU",
            "TUJUH PULUH DUA",
            "TUJUH PULUH TIGA",
            "TUJUH PULUH EMPAT",
            "TUJUH PULUH LIMA",
            "TUJUH PULUH ENAM",
            "TUJUH PULUH TUJUH",
            "TUJUH PULUH DELAPAN",
            "TUJUH PULUH SEMBILAN",
            "DELAPAN PULUH",
            "DELAPAN PULUH SATU",
            "DELAPAN PULUH DUA",
            "DELAPAN PULUH TIGA",
            "DELAPAN PULUH EMPAT",
            "DELAPAN PULUH LIMA",
            "DELAPAN PULUH ENAM",
            "DELAPAN PULUH TUJUH",
            "DELAPAN PULUH DELAPAN",
            "DELAPAN PULUH SEMBILAN",
            "SEMBILAN PULUH",
            "SEMBILAN PULUH SATU",
            "SEMBILAN PULUH DUA",
            "SEMBILAN PULUH TIGA",
            "SEMBILAN PULUH EMPAT",
            "SEMBILAN PULUH LIMA",
            "SEMBILAN PULUH ENAM",
            "SEMBILAN PULUH TUJUH",
            "SEMBILAN PULUH DELAPAN",
            "SEMBILAN PULUH SEMBILAN"
        );

        $result = "";

        // Handle millions
        if ($number >= 1000000) {
            $millions = (int) ($number / 1000000);
            $result .= $this->terbilang($millions) . " JUTA";
            $number %= 1000000; // Get the remainder
        }

        // Handle thousands
        if ($number >= 1000) {
            $thousands = (int) ($number / 1000);
            $result .= ($result ? " " : "") . $this->terbilang($thousands) . " RIBU";
            $number %= 1000; // Get the remainder
        }

        // Handle hundreds
        if ($number >= 100) {
            $hundreds = (int) ($number / 100);
            if ($hundreds == 1 && $number % 100 == 0) {
                $result .= ($result ? " " : "") . "SERATUS";
            } else {
                $result .= ($result ? " " : "") . $this->terbilang($hundreds) . " RATUS";
            }
            $number %= 100; // Get the remainder
        }

        // Handle tens and units
        if ($number > 0) {
            if ($number < 100) {
                $result .= ($result ? " " : "") . $words[$number];
            }
        }

        return trim($result);
    }

    public function generatePDF($id_tagihan)
    {
        $tagihan = Tagihan::with(['mahasiswa', 'semester'])->where('id_tagihan', $id_tagihan)->first();


        if (!$tagihan) {
            return redirect()->back()->with('error', 'Tagihan not found.');
        }


        $y = 'Rp. ' . number_format($tagihan->total_tagihan, 2, ',', '.');

        $total_tagihan_terbilang = $this->terbilang($tagihan->total_tagihan);

        $z = (int) $tagihan->total_tagihan - (int) $tagihan->total_bayar;

        $q = 'Rp. ' . number_format($z, 2, ',', '.');

        $tanggal = $tagihan->updated_at->locale('id')->isoFormat('D MMMM YYYY');

        $pdfData = [
            'title' => 'BuktiPembayaran-' . $tagihan->mahasiswa->nama . '-' . $tagihan->semester->nama_semester,
            'tanggal' => $tanggal,
            'kurang' => $q,
            'id_tagihan' => $tagihan->id_tagihan,
            'nama' => $tagihan->mahasiswa->nama,
            'NIM' => $tagihan->NIM,
            'total_tagihan' => $y,
            'x' => $total_tagihan_terbilang,
            'semester' => $tagihan->semester->nama_semester,
            'total_bayar' => $tagihan->total_bayar,
            'status' => $tagihan->status_tagihan,
        ];

        // Load the view and pass data to it, then generate the PDF
        $pdf = Pdf::loadView('livewire.mahasiswa.keuangan.download', $pdfData)->setPaper('a4', 'landscape');

        // Return the generated PDF file as a response for download
        return $pdf->stream('BuktiPembayaran-' . $tagihan->mahasiswa->nama . '-' . $tagihan->semester->nama_semester . '.pdf');
    }
}
