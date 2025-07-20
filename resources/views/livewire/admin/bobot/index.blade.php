<div>
    <div class="mx-5">
        <div class="flex flex-col justify-between mt-4 ml-4">
            <div class="flex justify-between items-center">
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li aria-current="page">
                        <div class="flex items-center">
                            <a wire:navigate.hover  href="{{ route('admin.bobot') }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center">
                                <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">cek Bobot</span>
                                <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
            <div class="bg-white shadow-lg p-4 mt-4 mb-4 rounded-lg max-w-full">
                <livewire:table.DosenTable :url="'bobot'"/>
            </div>
        </div>
    </div>
</div>
