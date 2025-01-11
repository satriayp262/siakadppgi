<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function handleNotification(Request $request)
    {
        // Ambil data dari request
        $json = $request->getContent();
        $notification = json_decode($json);

        // Validasi signature key
        $serverKey = config('midtrans.serverKey');
        $orderId = $notification->order_id;
        $statusCode = $notification->status_code;
        $grossAmount = $notification->gross_amount;
        $signatureKey = $notification->signature_key;

        $hashedKey = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

        if ($hashedKey !== $signatureKey) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        // Cari transaksi berdasarkan order_id
        $transaction = Transaksi::where('order_id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Proses status transaksi
        $message = 'Unknown transaction status.';
        switch ($notification->transaction_status) {
            case 'capture':
            case 'settlement':
                $transaction->status = 'success';
                $message = 'Transaction successful.';
                break;

            case 'pending':
                $transaction->status = 'pending';
                $message = 'Transaction is pending.';
                break;

            case 'deny':
            case 'cancel':
            case 'expire':
                $transaction->status = 'failed';
                $message = 'Transaction failed or expired.';
                break;

            default:
                $transaction->status = 'unknown';
                break;
        }

        // Simpan informasi tambahan (opsional)
        $transaction->payment_type = $notification->payment_type ?? null;
        $transaction->va_number = $notification->va_numbers[0]->va_number ?? null;
        $transaction->save();

        return response()->json(['message' => $message], 200);
    }
}
