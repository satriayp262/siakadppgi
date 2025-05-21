<div class="p-1 bg-white shadow-sm rounded-md mb-2">
    <div class="flex flex-wrap items-center gap-4">
        <div class="w-64">
            <select wire:model.live="semesterFilter"
                class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Semua Semester</option>
                <option value="{{ $this->activeSemesterId }}">
                    Semester Aktif
                </option>
                @foreach ($this->semesters as $semester)
                    <option value="{{ $semester->id_semester }}">
                        {{ $semester->nama_semester }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
