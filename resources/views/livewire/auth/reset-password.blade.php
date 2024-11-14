<div class="flex items-center justify-center w-full min-h-screen bg-custom-bg bg-contain bg-repeat" style="background-image: url('{{ asset('img/background.jpg') }}');">
    <div class="py-8 px-4 w-[400px] space-y-8 bg-white shadow-md rounded-lg">
        <div class="text-center">
            <img class="mx-auto h-20" src="{{ asset('img/siakad_polda_logo.png') }}" alt="Your Company">
            <p class="mt-12 text-sm tracking-tight text-gray-900">
                Isi dengan Password baru
            </p>
        </div>
        <form wire:submit.prevent="resetPassword" class="space-y-6">
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
                    {{ session('status') }}
                </div>
            @elseif (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                <input wire:model="email" id="email" type="email" disabled
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                @error('email')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                <input wire:model="password" id="password" type="password"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                @error('password')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Confirm
                    Password</label>
                <input wire:model="password_confirmation" id="password_confirmation" type="password"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                @error('password_confirmation')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-purple-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-700">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>
