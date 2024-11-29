<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true"
        class="flex items-center mt-3 px-4 py-2 text-sm text-white bg-purple2 hover:bg-customPurple rounded-md">
        Selengkapnya..
    </button>

    <!-- Modal Background -->
    <div x-show="isOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="w-1/2 bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">{{ $pengumuman->title }}</h3>
                <button @click="isOpen=false"
                    class="px-3 text-gray-900 rounded-sm shadow hover:bg-red-500">&times;</button>
            </div>
            <div class="p-4">
                <div class="p-4 max-h-[500px] overflow-y-auto">
                    <!-- Content for Display Only -->

                    <img src="{{ asset('storage/image/pengumuman/' . $pengumuman->image) }}"
                        alt="{{ $pengumuman->title }}" class="w-full h-full object-cover mb-4 rounded">

                    <div class="mb-4">
                        <h4 class="text-md mb-2">
                            {{ $pengumuman->desc }}
                        </h4>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-md mb-2">
                            <a href="{{ asset('storage/file/pengumuman/' . $pengumuman->file) }}" target="_blank"
                                class="text-blue-500 hover:underline">
                                {{ $pengumuman->title }}.pdf
                            </a>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
