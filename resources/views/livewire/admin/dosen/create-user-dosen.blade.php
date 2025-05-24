<div x-data="{ isOpen: false, load: false }" @modal-closed.window="isOpen = false">
    <!-- Button to open the modal -->
    <button @click="isOpen=true; load=true"
        class="inline-block px-4 py-2 text-white bg-green-500 rounded hover:bg-green-700">
        <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd"
                d="M9 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H7Zm8-1a1 1 0 0 1 1-1h1v-1a1 1 0 1 1 2 0v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 0 1-1-1Z"
                clip-rule="evenodd" />
        </svg>
    </button>
    <div x-show="isOpen && load" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75">
        <div class="w-full max-w-2xl mx-4 bg-white shadow-lg">
            <div class="flex items-center justify-between p-4 bg-gray-200 rounded-t-lg">
                <h3 class="text-xl font-semibold">Buat User Dosen</h3>
                <div @click="isOpen=false" class="px-3 rounded-sm shadow hover:bg-red-500">
                    <button class="text-gray-900">&times;</button>
                </div>
            </div>
            <div class="p-4">
                <form wire:submit.prevent="createUser">
                    @csrf <!-- CSRF protection -->
                    <div class="mb-4">
                        <div class="flex flex-col">
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 text-left">Email</label>
                            <input type="email" id="email_{{ $id_dosen }}" wire:model="email"
                                class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror

                            <label for="password"
                                class="block mt-2 text-sm font-medium text-gray-700 text-left">Password</label>
                            <input type="password" id="password_{{ $id_dosen }}" wire:model="password"
                                class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                readonly>
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

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
