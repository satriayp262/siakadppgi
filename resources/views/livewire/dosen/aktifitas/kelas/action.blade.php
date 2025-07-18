<div class="flex justify-center space-x-2 items-center ">
    <livewire:dosen.aktifitas.kelas.edit :id_aktifitas="$row->id_aktifitas" :id_kelas="$row->id_kelas" :id_mata_kuliah="$row->id_mata_kuliah"
        wire:key="edit-{{ rand() . $row->id_aktifitas }}" />

    <button class="inline-block px-2 sm:px-4 py-1 sm:py-2 text-white bg-red-500 rounded hover:bg-red-700"
        wire:key="delete-{{ $row->id_aktifitas }}" onclick="confirmDelete('{{ $row->id_aktifitas }}')">
        <svg class="w-4 sm:w-6 h-4 sm:h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
        </svg>
    </button>

    {{-- <a wire:navigate.hover
        href="{{ route('dosen.aktifitas.kelas.aktifitas', ['kode_mata_kuliah' => $row->kode_mata_kuliah, 'nama_kelas' => str_replace('/', '-', $row->nama_kelas), 'nama_aktifitas' => $row->nama_aktifitas]) }}"
        class="py-0 sm:py-3 px-3 sm:px-5 bg-blue-500 hover:bg-blue-700 rounded text-white text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <!-- Paper outline -->
  <rect x="4" y="2" width="16" height="20" rx="2" ry="2" stroke-width="2" stroke-linejoin="round"/>

  <!-- Paper lines -->
  <line x1="8" y1="7" x2="16" y2="7" stroke-width="2" stroke-linecap="round"/>
  <line x1="8" y1="11" x2="16" y2="11" stroke-width="2" stroke-linecap="round"/>
  <line x1="8" y1="15" x2="16" y2="15" stroke-width="2" stroke-linecap="round"/>
</svg>

    </a> --}}
</div>
