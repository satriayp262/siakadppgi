<div class="flex items-center justify-center w-full min-h-screen">
    <div class="py-8 px-4 w-[400px] space-y-8 bg-white shadow-md rounded-lg">
        <div class="text-center">
            <img class="h-20 mx-auto" src="{{ asset('img/siakad_polda_logo.png') }}" alt="Your Company">
            <p class="mt-12 text-sm tracking-tight text-gray-900">
                Link untuk mereset password akan dikirim melalui Email
            </p>
            <div>
                @if (session()->has('error'))
                    <div id="flash-message"
                        class="flex items-center justify-between p-2 mx-8 mt-4 text-white bg-red-600 rounded-lg">
                        <span>{{ session('error') }}</span>
                        <button class="p-1" onclick="document.getElementById('flash-message').style.display='none'"
                            class="font-bold text-white">
                            &times;
                        </button>
                    </div>
                @endif
            </div>
            <div>
                @if (session()->has('message'))
                    <div id="flash-message"
                        class="flex items-center justify-between p-2 mx-8 mt-4 text-white bg-green-600 rounded-lg">
                        <span>{{ session('message') }}</span>
                        <button class="p-1" onclick="document.getElementById('flash-message').style.display='none'"
                            class="font-bold text-white">
                            &times;
                        </button>
                    </div>
                @endif
            </div>
        </div>
        <form wire:submit="sendResetLink" class="h-full">
            <div class="space-y-6">
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                    <div class="mt-2">
                        <input
                            class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            wire:model='email' type="text" name="email" id="email">
                        @error('email')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div wire:loading>
                    <div class="flex flex-row items-center w-full mt-2 space-x-2">
                        <div class="spinner"></div>
                        <div class="spinner-text">Mengirimkan email...</div>
                    </div>
                </div>
                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-purple-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-600">Kirim
                        link login</button>
                </div>
            </div>
        </form>

    </div>
</div>
