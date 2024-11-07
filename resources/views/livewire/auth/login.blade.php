<div class="flex items-center justify-center w-full min-h-screen">
    <div class="py-8 px-4 w-[400px] space-y-8 bg-white shadow-md rounded-lg">
        <div class="text-center">
            <img class="h-20 mx-auto" src="{{ asset('img/siakad_polda_logo.png') }}" alt="Your Company">
            <p class="mt-12 leading-9 tracking-tight text-gray-900 text-md">Belum memiliki akun?
                <a href="/register" class="text-blue-600 hover:text-blue-800 hover:underline">Daftar</a>
            </p>
            <div>
                @if (session()->has('message'))
                    <div id="flash-message"
                        class="flex items-center justify-between p-2 mx-8 mt-4 text-white bg-red-600">
                        <span>{{ session('message') }}</span>
                        <button class="p-1" onclick="document.getElementById('flash-message').style.display='none'"
                            class="font-bold text-white">
                            &times;
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <form wire:submit="login" class="h-full">
            <div class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                    <div class="mt-2">
                        <input
                            class="block pl-2 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            wire:model='email' type="text" name="email" id="email">
                        @error('email')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="text-sm">
                            <a href="/forgot-password" class="text-blue-600 hover:text-blue-800 hover:underline">Forgot
                                password?</a>
                        </div>
                    </div>
                    <div class="mt-2 relative">
                        <input
                            class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            wire:model='password' type="password" name="password" id="password">
                        <button type="button" onclick="togglePassword('password', this)"
                            class="absolute inset-y-0 right-0 flex items-center px-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 eye-icon" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke="currentColor" stroke-width="2"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                        @error('password')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                    <div wire:loading>
                        <div class="flex flex-row items-center w-full mt-2 space-x-2">
                            <div class="spinner"></div>
                            <div class="spinner-text">Memproses Permintaan...</div>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" wire:loading.remove
                        class="flex w-full justify-center rounded-md bg-purple-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-purple-700">Masuk</button>
                    <button wire:loading disabled
                        class="flex w-full justify-center rounded-md bg-purple-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-purple-700">Masuk</button>

                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function togglePassword(id, button) {
        const input = document.getElementById(id);
        const eyeIcon = button.querySelector('svg');

        if (input.type === "password") {
            input.type = "text";
            // Change to closed eye icon
            eyeIcon.innerHTML = `
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>

                `; // Closed eye icon with a cross
        } else {
            input.type = "password";
            // Change back to default eye icon
            eyeIcon.innerHTML = `
                    <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                `; // Default eye icon
        }
    }
</script>
