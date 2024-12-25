<?php

namespace App\Livewire\Staff\Payment;

use Livewire\Component;
use Midtrans\Snap;
use App\Services\MidtransConfig;


class Index extends Component
{
    public $amount;
    public $snapToken;

    public function mount($amount)
    {
        $this->amount = $amount;
    }

    public function createTransaction()
    {
        \App\Services\MidtransConfig::setup();

        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => 10000,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        try {
            $this->snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.staff.payment.index');
    }
}
