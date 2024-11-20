<div class="flex items-center justify-center w-full min-h-screen bg-purple-400">

    <style>
        .box {
            position: fixed;
            top: 0;
            transform: rotate(80deg);
            left: 0;
            z-index: 0;
        }

        .wave {
            position: fixed;
            top: 0;
            left: 0;
            opacity: .4;
            position: absolute;
            top: 3%;
            left: 10%;
            background: #d904ff;
            width: 1500px;
            height: 1300px;
            margin-left: -150px;
            margin-top: -250px;
            transform-origin: 50% 48%;
            border-radius: 43%;
            animation: drift 7000ms infinite linear;
        }

        .wave.-three {
            animation: drift 7500ms infinite linear;
            position: fixed;
            background-color: #d904ff;
        }

        .wave.-two {
            animation: drift 3000ms infinite linear;
            opacity: .1;
            background: black;
            position: fixed;
        }

        .box:after {
            content: '';
            display: block;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 11;
            transform: translate3d(0, 0, 0);
        }

        @keyframes drift {
            from {
                transform: rotate(0deg);
            }

            from {
                transform: rotate(360deg);
            }
        }

        /*LOADING SPACE*/

        .contain {
            animation-delay: 4s;
            z-index: 1000;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-flow: row nowrap;
            flex-flow: row nowrap;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;

            background: #25a7d7;
            background: -webkit-linear-gradient(#25a7d7, #2962FF);
            background: linear-gradient(#25a7d7, #25a7d7);
        }

        .icon {
            width: 100px;
            height: 100px;
            margin: 0 5px;
        }

        /*Animation*/
        .icon:nth-child(2) img {
            -webkit-animation-delay: 0.2s;
            animation-delay: 0.2s
        }

        .icon:nth-child(3) img {
            -webkit-animation-delay: 0.3s;
            animation-delay: 0.3s
        }

        .icon:nth-child(4) img {
            -webkit-animation-delay: 0.4s;
            animation-delay: 0.4s
        }

        .icon img {
            -webkit-animation: anim 2s ease infinite;
            animation: anim 2s ease infinite;
            -webkit-transform: scale(0, 0) rotateZ(180deg);
            transform: scale(0, 0) rotateZ(180deg);
        }

        @-webkit-keyframes anim {
            0% {
                -webkit-transform: scale(0, 0) rotateZ(-90deg);
                transform: scale(0, 0) rotateZ(-90deg);
                opacity: 0
            }

            30% {
                -webkit-transform: scale(1, 1) rotateZ(0deg);
                transform: scale(1, 1) rotateZ(0deg);
                opacity: 1
            }

            50% {
                -webkit-transform: scale(1, 1) rotateZ(0deg);
                transform: scale(1, 1) rotateZ(0deg);
                opacity: 1
            }

            80% {
                -webkit-transform: scale(0, 0) rotateZ(90deg);
                transform: scale(0, 0) rotateZ(90deg);
                opacity: 0
            }
        }

        @keyframes anim {
            0% {
                -webkit-transform: scale(0, 0) rotateZ(-90deg);
                transform: scale(0, 0) rotateZ(-90deg);
                opacity: 0
            }

            30% {
                -webkit-transform: scale(1, 1) rotateZ(0deg);
                transform: scale(1, 1) rotateZ(0deg);
                opacity: 1
            }

            50% {
                -webkit-transform: scale(1, 1) rotateZ(0deg);
                transform: scale(1, 1) rotateZ(0deg);
                opacity: 1
            }

            80% {
                -webkit-transform: scale(0, 0) rotateZ(90deg);
                transform: scale(0, 0) rotateZ(90deg);
                opacity: 0
            }
        }
    </style>
    <div class='box'>
        <div class='wave -one'></div>
        <div class='wave -two'></div>
        <div class='wave -three'></div>
    </div>
    <div class="py-8 px-4 w-[400px] space-y-8 bg-white shadow-md rounded-lg">
        <div class="text-center">
            <img class="h-20 mx-auto" src="{{ asset('img/siakad_polda_logo.png') }}" alt="Your Company">

        </div>
        <form wire:submit="save" class="h-full">
            <div class="space-y-6">
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                    <div class="mt-2">
                        <input
                            class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            wire:model='name' type="text" name="name" id="name">
                        @error('name')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

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

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    <div class="mt-2">
                        <input
                            class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            wire:model='password' type="password" name="password" id="password">
                        @error('password')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Confirm
                        Password</label>
                    <div class="mt-2">
                        <input
                            class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            wire:model='password_confirmation' type="password" name="password_confirmation"
                            id="password_confirmation">
                        @error('password_confirmation')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div wire:loading>
                    <div class="flex flex-row items-center w-full mt-2 space-x-2">
                        <div class="spinner"></div>
                        <div class="spinner-text">Memproses Permintaan...</div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" wire:loading.remove
                        class="flex w-full justify-center rounded-md bg-purple-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-600">Register</button>
                    <button disabled wire:loading
                        class="flex w-full justify-center rounded-md bg-purple-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-600">Register</button>
                </div>
            </div>
        </form>

    </div>
</div>
