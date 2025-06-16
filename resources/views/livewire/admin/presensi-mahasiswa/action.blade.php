<div class="flex justify-center space-x-2 py-2">
    @php
        $sudahKirim = \App\Models\RiwayatSP::where('nim', $row->NIM)->exists();
    @endphp
    @if ($row->alpha_count >= 2 && !$sudahKirim)
        <button onclick="kirimEmail('{{ $row->NIM }}', '{{ $row->nama }}')"
            class="py-2 px-4 bg-blue-500 text-white hover:bg-blue-700 rounded">
            Kirim SP
        </button>
    @else
        <button class="py-2 px-4 bg-gray-400 text-white rounded" disabled>
            Kirim SP
        </button>
    @endif
</div>

<script>
    function kirimEmail(nim, nama_mahasiswa) {
        Swal.fire({
            title: `Apakah anda yakin ingin mengirim surat peringatan ke ${nama_mahasiswa}?`,
            text: "Data yang telah dikirim tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#28a745',
            confirmButtonText: 'Kirim'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('kirimEmail', { nim: nim });
            }
        });
    }
</script>
