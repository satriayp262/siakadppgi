<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <button @click="isOpen=true" class="inline-block px-4 py-2 text-white bg-green-500 rounded hover:bg-green-700">
        <svg class="w-6 h-6 font-black text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="14" height="14" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                d="M5 12h14m-7 7V5" />
        </svg>
    </button>

    <div>
        <div x-show="isOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
            <div class="w-1/2 bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                    <h3 class="text-xl font-semibold">Tambah Anggota Kelas</h3>
                    <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                        <button class="text-gray-900">&times;</button>
                    </div>
                </div>
                <div class="p-4 text-left">
                    <div class="p-4 max-h-[500px] overflow-y-auto">
                        <form wire:submit="update">
                            <p class="mb-4 text-gray-600 font-lg">Cari Mahasiswa berdasarkan Nama atau NIM</p>
                            <div class="mb-4">
                                <input type="text" wire:model.live="search" placeholder="Cari Mahasiswa..."
                                    class="block w-full px-2 py-2 bg-gray-200 border-gray-300 rounded-md focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm">
                            </div>

                            <select id="mahasiswa" wire:model.live="selectedMahasiswa" name="mahasiswa"
                                class="block w-full px-2 py-2 bg-gray-200 border-gray-300 rounded-md focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 sm:text-sm"
                                size="5">
                                <option value="" disabled selected>Pilih Mahasiswa</option>
                                @foreach ($mahasiswa as $item)
                                    <option class="p-2" value="{{ $item->id_mahasiswa }}">{{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>



                            <div class="flex justify-end p-4 bg-gray-200 rounded-b-lg">
                                <button type="button" @click="isOpen = false"
                                    class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Close</button>
                                <button type="submit"
                                    class="px-4 py-2 ml-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('confirmation', event => {
            let message = event.detail.params[0];
            Swal.fire({
                title: `Mahasiswa Ini sudah menjadi anggota kelas ${message}`,
                text: "Apakah anda yakin ingin mengganti kelas Mahasiswa ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5ce85c',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Pindah'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('confirmed');
                }
            });
        });
    });
    function confirmDelete(id, nama_kelas) {
            Swal.fire({
                title: `Apakah anda yakin ingin menghapus Kelas ${nama_kelas}?`,
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#28a745',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroy', id);
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('KelasWarning', event => {
                Swal.fire({
                    title: 'Warning!',
                    text: event.detail.params.message,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Dispatch the modal-closed event to close the modal
                    window.dispatchEvent(new CustomEvent('modal-closed'));
                });
            });
        });
        
</script>
