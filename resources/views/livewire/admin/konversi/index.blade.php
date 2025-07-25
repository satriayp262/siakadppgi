<div class="mx-5">
    <div wire:loading wire:target="destroySelected,destroy"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="spinner loading-spinner"></div>
    </div>
    <div class="flex flex-col justify-between mt-2">
        <!-- Modal Form -->
        <div class="flex justify-between mt-2">
            <livewire:admin.konversi.create />
        </div>
        <div>
            @if (session()->has('message'))
                @php
                    $messageType = session('message_type', 'success'); // Default to success
                    $bgColor =
                        $messageType === 'error'
                            ? 'bg-red-500'
                            : ($messageType === 'warning'
                                ? 'bg-blue-500'
                                : 'bg-green-500');
                @endphp
                <div id="flash-message"
                    class="flex items-center justify-between p-2 mx-2 mt-2 text-white{{ $bgColor }} rounded">
                    <span>{{ session('message') }}</span>
                    <button class="p-1" onclick="document.getElementById('flash-message').remove();"
                        class="font-bold text-white">
                        &times;
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
        <div class="justify-between flex items-center mr-2">
            <div class="flex flex-col">
                <h1 class="text-2xl font-bold text-customPurple">Daftar Konversi</h1>
                <p class="text-sm text-gray-500">Halaman Ini untuk konversi nilai seperti (MBKM)</p>
                </p>
            </div>
        </div>
        <livewire:table.konversiTable />
    </div>
</div>
<script>
    function confirmDelete(id, nama) {
        Swal.fire({
            title: `Apakah anda yakin ingin menghapus TTD ${nama}?`,
            text: "Data yang telah dihapus tidak dapat dikembalikan! dan nilai mahasiswa akan menjadi 0",
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
    window.addEventListener('bulkDelete.alert.konversi-table-chavt8-table', (event) => {
        const ids = event.detail[0].ids;

        // console.log(event.detail[0].ids);
        if (!ids || ids.length === 0) return;

        Swal.fire({
            title: `Apakah anda yakin ingin menghapus ${ids.length} data TTD?`,
            text: "Data yang telah dihapus tidak dapat dikembalikan! dan nilai mahasiswa akan menjadi 0",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                // Livewire.find(
                //     document.querySelector('[wire\\:id]').getAttribute('wire:id')
                // ).call('destroySelected', ids);
                @this.call('destroySelected', ids);
            }
        });
    });

    function isMovingToDropdown(event) {
        const target = event.relatedTarget; // Elemen tujuan kursor
        return target && (target.closest('.relative') !== null);
    }
</script>
<script>
    document.addEventListener('livewire:navigated', function() {
        window.addEventListener('destroyed', event => {
            Swal.fire({
                title: 'Success!',
                text: event.detail.params.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Dispatch the modal-closed event to close the modal
                window.dispatchEvent(new CustomEvent('modal-closed'));
            });
        });
    });
    document.addEventListener('livewire:navigated', function() {
        window.addEventListener('updated', event => {
            Swal.fire({
                title: 'Success!',
                text: event.detail.params.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Dispatch the modal-closed event to close the modal
                window.dispatchEvent(new CustomEvent('modal-closed'));
            });
        });
    });
    document.addEventListener('livewire:navigated', function() {
        window.addEventListener('created', event => {
            Swal.fire({
                title: 'Success!',
                text: event.detail.params.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Dispatch the modal-closed event to close the modal
                window.dispatchEvent(new CustomEvent('modal-closed'));
            });
        });
    });
</script>
