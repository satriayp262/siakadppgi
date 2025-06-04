<div class="mx-5">
    <div class="flex flex-col justify-between mx-4 mt-4">
        <div class="flex justify-between mt-2">
            <div class="flex space-x-2">
                <livewire:admin.periode.create />
            </div>
        </div>
        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
            <livewire:table.periode-table />
        </div>
    </div>
</div>
<script>
    function confirmDelete(id_periode, sesi) {
        Swal.fire({
            title: `Apakah anda yakin ingin menghapus Periode ${sesi}?`,
            text: "Data yang telah dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('destroy', id_periode);
            }
        });
    }

    window.addEventListener('confirm-create-pengumuman', function() {
        Swal.fire({
            title: 'Periode berhasil ditambahkan!',
            text: "Apakah Anda ingin membuat pengumuman?",
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Ya, buat pengumuman',
            cancelButtonText: 'Tidak, nanti saja'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('kirim');
            }
        });
    });

    window.addEventListener('bulkDelete.alert.periode-table-hwo90b-table', (event) => {
        const ids = event.detail[0].ids;

        // console.log(event.detail[0].ids);
        if (!ids || ids.length === 0) return;

        Swal.fire({
            title: `Apakah anda yakin ingin menghapus ${ids.length} data Periode?`,
            text: "Data yang telah dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('destroySelected', ids);
            }
        });
    });
</script>
