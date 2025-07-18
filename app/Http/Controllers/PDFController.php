<?php

namespace App\Http\Controllers;

use App\Models\Konfirmasi_Pembayaran;
use App\Models\KRS;
use App\Models\Staff;
use App\Models\Transaksi;
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

    public function generatePDF($no_kwitansi)
    {
        $tagihan = Tagihan::with(['mahasiswa', 'semester'])->where('no_kwitansi', $no_kwitansi)->first();

        if (!$tagihan) {
            return redirect()->back()->with('error', 'Tagihan not found.');
        }

        if ($tagihan->metode_pembayaran == 'Midtrans Payment') {
            $transaksi = Transaksi::where('id_tagihan', $tagihan->id_tagihan)->first();
            if (!$transaksi) {
                return redirect()->back()->with('error', 'Transaksi not found.');
            }
            //$jam = substr($transaksi->tanggal_transaksi, 11, 8);

            $waktu = $transaksi->tanggal_transaksi;
            $jam = \Carbon\Carbon::parse($waktu)->format('h:i:s A');

        } elseif ($tagihan->metode_pembayaran == 'Transfer Rek PPGI') {
            $konfirmasi = Konfirmasi_Pembayaran::where('id_tagihan', $tagihan->id_tagihan)->first();
            if (!$konfirmasi) {
                return redirect()->back()->with('error', 'Konfirmasi Pembayaran not found.');
            }
            $waktu = $konfirmasi->tanggal_pembayaran;
            $jam = \Carbon\Carbon::parse($waktu)->format('h:i:s A');
        } else {
            $waktu = $tagihan->updated_at;
            $jam = \Carbon\Carbon::parse($waktu)->format('h:i:s A');
        }

        $staff = Staff::find($tagihan->id_staff);

        $y = 'Rp. ' . number_format($tagihan->total_tagihan, 2, ',', '.');

        $total_tagihan_terbilang = $this->terbilang($tagihan->total_tagihan);

        $z = (int) $tagihan->total_tagihan - (int) $tagihan->total_bayar;

        $q = 'Rp. ' . number_format($z, 2, ',', '.');

        $tanggal = $tagihan->updated_at->locale('id')->isoFormat('D MMMM YYYY');

        $t = $staff->ttd;

        $kwitansi = $tagihan->no_kwitansi;

        //krs untuk cari kelas
        $krs = KRS::with(['kelas', 'mahasiswa'])
            ->where('NIM', $tagihan->mahasiswa->NIM)
            ->first();




        $imagePath = storage_path("app/public/image/ttd/{$t}"); // Adjust path based on your storage
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageBase64 = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;



        $pdfData = [
            'title' => 'BuktiPembayaran-' . $tagihan->mahasiswa->nama . '-' . $tagihan->semester->nama_semester,
            'tanggal' => $tanggal,
            'kurang' => $q,
            'id_tagihan' => $tagihan->id_tagihan,
            'nama' => $tagihan->mahasiswa->nama,
            'NIM' => $tagihan->NIM,
            'total_tagihan' => $y,
            'x' => $total_tagihan_terbilang,
            'staff' => $tagihan->staff->nama_staff,
            'ttd' => $imageBase64,
            'semester' => $tagihan->semester->nama_semester,
            'total_bayar' => $tagihan->total_bayar,
            'status' => $tagihan->status_tagihan,
            'nip' => $tagihan->staff->nip,
            'kwitansi' => $kwitansi,
            'pembayaran' => $tagihan->jenis_tagihan,
            'metode' => $tagihan->metode_pembayaran,
            'jam' => $jam,
            'kelas' => $krs->kelas->nama_kelas,

        ];
        // dd($pdfData);
        // Load the view and pass data to it, then generate the PDF
        $pdf = Pdf::loadView('livewire.mahasiswa.keuangan.download', $pdfData)->setPaper([0, 0, 905.512, 283.465]); // Set the paper size to 32 * 10 cm

        // Return the generated PDF file as a response for download
        return $pdf->stream('BuktiPembayaran-' . $tagihan->mahasiswa->nama . '-' . $tagihan->semester->nama_semester . '.pdf');
    }
}
