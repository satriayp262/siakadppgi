<?php

namespace App\Livewire\Admin\Pengumuman;

use App\Models\Pengumuman;
use Livewire\Component;
use livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[On('aaaaa')]
    public function handleaaaaa(){
        dd('asdasd');
    }
    public function destroy($id)
    {
        $pengumuman = Pengumuman::find($id);
        $pengumuman->delete();

        $this->dispatch('destroyed', ['message' => 'Pengumuman Deleted Successfully']);
    }

    public function render()
    {
        $pengumuman = Pengumuman::query()->orderBy('created_at', 'desc')->paginate(10);
        return view('livewire.admin.pengumuman.index',[
            'pengumuman' => $pengumuman
        ]);
    }
}
