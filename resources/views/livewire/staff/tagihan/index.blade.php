<div class="mx-5">
    <div class="flex flex-col justify-between mt-2">
        <!-- Modal Form -->
        <div class="flex justify-end space-x-2 mt-2">
            <div class="flex items-start mr-auto">
                <livewire:staff.tagihan.group-create />
                @if ($buttontransaksi)
                    <livewire:staff.tagihan.multiple-create :selectedMahasiswa="$selectedMahasiswa" />
                @endif
            </div>
        </div>
        <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
            @livewire('table.staff.tagihan.buat-tagihan-table')
        </div>
    </div>
    <script>
        window.addEventListener('bulkDelete.alert.buat-tagihan-table-njgizx-table', (event) => {
            const ids = event.detail[0].ids;
            if (ids.length === 0) {
                return;
            }
            @this.call('Tagihan', ids);
        });
    </script>
