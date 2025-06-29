<?php

namespace App\Livewire\Admin\Konversi;

use App\Models\KHS;
use App\Models\KonversiNilai;
use Livewire\Component;
use Livewire\Attributes\On;

class Index extends Component
{
    public function destroySelected($ids): void
    {
        foreach ($ids as $id) {
            $konversi = KonversiNilai::find($id);

            if ($konversi) {
                KHS::updateOrCreate(
                    ['id_krs' => $konversi->id_krs],
                    ['bobot' => 0]
                );

                $konversi->delete();
            }
        }

        $this->dispatch('pg:eventRefresh-konversi-table-chavt8-table');
        $this->dispatch('destroyed', ['message' => 'Konversi Berhasil dihapus']);

    }

    #[On('konversiUpdated')]
    public function handlekonversiEdited()
    {
        $this->dispatch('pg:eventRefresh-konversi-table-chavt8-table');

        $this->dispatch('updated', ['message' => 'Konversi Edited Successfully']);

    }

    public function destroy($id_konversi_nilai)
    {
        $konversi = KonversiNilai::find($id_konversi_nilai);
        KHS::updateOrCreate([
            'id_krs' => $konversi->id_krs
        ], [
            'bobot' => 0
        ]);
        $konversi->delete();
        $this->dispatch('pg:eventRefresh-konversi-table-chavt8-table');

        $this->dispatch('destroyed', params: ['message' => 'Konversi deleted Successfully']);


    }

    #[On('konversiCreated')]
    public function handlekonversiCreated()
    {
        $this->dispatch('pg:eventRefresh-konversi-table-chavt8-table');
        $this->dispatch('created', ['message' => 'Konversi Created Successfully']);


    }
    public function render()
    {
        return view('livewire.admin.konversi.index');
    }
}
