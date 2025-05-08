<button wire:key="delete-{{ rand(). $row->id_kelas }}"
    class="inline-block px-2 sm:px-4 py-1 sm:py-2 text-white bg-red-500 rounded hover:bg-red-700"
    onclick="confirmDelete({{ $row->id_paket_krs }}, '{{ $row->kelas->nama_kelas }}', '{{ $row->semester->nama_semester }}')"><svg
        class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
        viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
            stroke-width="2"
            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
    </svg>
</button>