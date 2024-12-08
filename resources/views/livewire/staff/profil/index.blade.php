<div class="mx-5">
    <div class="flex flex-col justify-between mt-2">
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <div class="max-w-full p-4 mt-4 mb-4 bg-white rounded-lg shadow-lg">

            </div>
        </div>
    </div>
    <!-- Pagination Controls -->
    <div class="py-8 mt-4 text-center">
        {{-- {{ $mahasiswas->links('') }} --}}
    </div>
</div>
<script>
    function confirmDelete(id, nama_staff) {
        Swal.fire({
            title: `Apakah anda yakin ingin menghapus Staff ${nama_staff}?`,
            text: "Data yang telah dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('destroy', id);
            }
        });
    }
</script>
