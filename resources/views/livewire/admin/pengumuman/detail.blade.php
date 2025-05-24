<div x-data="{ isOpen: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    @if (auth()->check())
        <button @click="isOpen=true"
            class="flex items-center px-3 py-2 text-sm text-white bg-yellow-500 hover:bg-yellow-700 rounded-md">
            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-width="2"
                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
        </button>
    @else
        <button @click="isOpen=true"
            class="flex items-center mt-3 px-4 py-2 text-sm text-white bg-purple2 hover:bg-customPurple rounded-md">
            Selengkapnya..
        </button>
    @endif

    <!-- Modal Background -->
    <div x-show="isOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <!-- Modal Content -->
        <div class="w-full max-w-2xl mx-4 bg-white rounded-lg shadow-lg">
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
                        alt="{{ $pengumuman->title }}" class="w-fit h-fit object-cover mb-4 rounded">

                    <div class="mb-4">
                        <p class="text-md mb-2 break-words whitespace-pre-line">
                            {{ $pengumuman->desc }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-md mb-2">
                            @if ($pengumuman->file)
                                <a href="{{ asset('storage/file/pengumuman/' . $pengumuman->file) }}" target="_blank"
                                    class="text-purple2 hover:underline">
                                    {{ $pengumuman->title }}.pdf
                                </a>
                            @else
                            @endif
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
