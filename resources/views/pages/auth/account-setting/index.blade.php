<x-auth-layout title="Account Setting">
    <section class="container mx-auto w-[95%]">
        <div class="shadow-xl">
            <div
                class="flex align-center justify-between gap-2 flex-wrap bg-violet-900 p-[1em] rounded-tr-md rounded-tl-md">
                <h5 class="text-white text-xl font-medium">
                    <x-icon type="gear" />
                    Account Setting
                </h5>
                <a href="{{route('home')}}" class="text-white">
                    <x-icon type="arrow-left" />
                    back
                </a>
            </div>
            <div class="flex justify-center p-5">
                <form action="" id="form-update-account-setting" class="w-[90%] h-[95%] max-w-[550px] p-10">
                    @csrf
                    <fieldset>
                        <legend class="text-primary font-medium text-2xl mb-5 text-center">Abaca Classification System
                        </legend>

                        {{-- fname --}}
                        <div class="mb-5">
                            <label for="fname" class="font-medium text-primary block">First Name</label>
                            <input type="text" name="fname" id="fname"
                                class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-sm"
                                placeholder="Enter First Name" value="{{ old('fname', auth()->user()->fname) }}">
                            <small class="text-red-500 font-medium error-container error-fname"></small>
                        </div>
                        {{-- mmame --}}
                        <div class="mb-5">
                            <label for="mname" class="font-medium text-primary block">Middle Initial</label>
                            <input type="text" name="mname" id="mname"
                                class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-sm"
                                placeholder="Enter Middle Initial" value="{{ old('mname', auth()->user()->mname) }}">
                            <small class="text-red-500 font-medium error-container error-mname"></small>
                        </div>
                        {{-- lname --}}
                        <div class="mb-5">
                            <label for="lname" class="font-medium text-primary block">Last Name</label>
                            <input type="text" name="lname" id="lname"
                                class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-sm"
                                placeholder="Enter Last Name" value="{{ old('lname', auth()->user()->lname) }}">
                            <small class="text-red-500 font-medium error-container error-lname"></small>
                        </div>

                        {{-- brgy --}}
                        <div class="mb-5">
                            <label for="brgy" class="font-medium text-primary block">Barangay</label>
                            <select name="brgy" id="brgy"
                                class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-sm">
                                <option value="" disabled>Select a location</option>

                                @php
                                $barangays = [
                                'BENIT',
                                'BUAC DAKU',
                                'BUAC GAMAY',
                                'CABADBARAN',
                                'CONCEPCION',
                                'CONSOLACION',
                                'DAGSA',
                                'HIBOD-HIBOD',
                                'HINDANGAN',
                                'HIPANTAG',
                                'JAVIER',
                                'KAHUPIAN',
                                'KANANGKAAN',
                                'KAUSWAGAN',
                                'LP CONCEPCION',
                                'LIBAS',
                                'LOM-AN',
                                'MABICAY',
                                'MAAC',
                                'MAGATAS',
                                'MAHAYAHAY',
                                'MALINAO',
                                'MARIA PLANA',
                                'MILAGROSO',
                                'OLISIHAN',
                                'PANCHO VILLA',
                                'PANDAN',
                                'RIZAL',
                                'SALVACION',
                                'SF MABUHAY',
                                'SAN ISIDRO',
                                'SAN JOSE',
                                'SAN JUAN (AGATA)',
                                'SAN MIGUEL',
                                'SAN PEDRO',
                                'SAN ROQUE',
                                'SAN VICENTE',
                                'SANTA MARIA',
                                'SUBA',
                                'TAMPOONG',
                                'ZONE I',
                                'ZONE II',
                                'ZONE III',
                                'ZONE IV',
                                'ZONE V',
                                ];
                                $selectedBrgy = old('brgy', auth()->user()->brgy);
                                @endphp

                                @foreach ($barangays as $brgy)
                                <option value="{{ $brgy }}" {{ $selectedBrgy===$brgy ? 'selected' : '' }}>
                                    {{ $brgy }}
                                </option>
                                @endforeach
                            </select>
                            <small class="text-red-500 font-medium error-container error-brgy"></small>
                        </div>

                        {{-- username --}}
                        <div class="mb-5">
                            <label for="username" class="font-medium text-primary block">Username</label>
                            <input type="text" name="username" id="username"
                                class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-sm"
                                placeholder="Enter Username" value="{{ old('username', auth()->user()->username) }}">
                            <small class="text-red-500 font-medium error-container error-username"></small>
                        </div>

                        {{-- password --}}
                        <div class="mb-5">
                            <label for="password" class="font-medium text-primary block">New Password</label>
                            {{-- input and show/hide password --}}
                            <div class="flex items-center">
                                <input type="password" name="password" id="password"
                                    class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-tl-sm rounded-bl-sm"
                                    placeholder="Atleast 8 Characters long" autocomplete="current-password">

                                {{-- show hide pass --}}
                                <div
                                    class="block border border-violet-800 p-[0.5em] border-l-0 cursor-pointer rounded-tr-sm rounded-br-sm">
                                    <x-icon type="eye-slash text-primary" id="show-hide-password-toggler" />
                                </div>
                            </div>
                            <small class="text-red-500 font-medium error-container error-password"></small>
                        </div>

                        <div class="mb-5">
                            <label for="password_confirmation" class="font-medium text-primary block">New Password
                                Confirmation</label>
                            {{-- input and show/hide password --}}
                            <div class="flex items-center">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-tl-sm rounded-bl-sm"
                                    placeholder="Must be the same with password" autocomplete="current-password">

                                {{-- show hide pass --}}
                                <div
                                    class="block border border-violet-800 p-[0.5em] border-l-0 cursor-pointer rounded-tr-sm rounded-br-sm">
                                    <x-icon type="eye-slash text-primary" id="show-hide-password-toggler-2" />
                                </div>
                            </div>
                            <small class="text-red-500 font-medium error-container error-password"></small>
                        </div>

                        {{-- submit btn --}}
                        <x-button type="submit" button-class="btn-primary w-full mb-4 font-medium" id="submit-btn"
                            data-id="{{$id}}">
                            <x-icon type="check" />
                            Save Setting
                        </x-button>

                    </fieldset>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // show hide password
            showHidePass();
            showHidePass2();

            saveAccountSetting();
        });

        const saveAccountSetting = () => {
            const form = document.getElementById('form-update-account-setting');
            const submit_btn = document.getElementById('submit-btn');

            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                submit_btn.disabled = true;
                clearErrors();

                try {
                    const id = submit_btn.dataset.id;

                    const json_data = Object.fromEntries(new FormData(e.target));

                    await axios.put(`/account-setting/${id}`, json_data, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    Toastify({
                        text: 'Successfully save account setting',
                        duration: 2000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "left",
                        stopOnFocus: true,
                        style: {
                            background: "rgb(100, 225, 100)"
                        }
                    }).showToast();

                    submit_btn.disabled = false;

                } catch (error) {
                    console.error(error);

                    if (error.response.data.errors) {
                        for (const [key, val] of Object.entries(error.response.data.errors)) {
                            const error_wrapper = document.querySelector(`.error-${key}`);
                            error_wrapper.textContent = val;
                        }

                        submit_btn.disabled = false;
                        return;
                    }


                    Toastify({
                        text: 'Server Error, Something went wrong',
                        duration: 2000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "left",
                        stopOnFocus: true,
                        style: {
                            background: 'rgb(225, 100, 100)'
                        }
                    }).showToast();

                    submit_btn.disabled = false;
                    return;

                }
            });
        };

        // show hide password
        function showHidePass() {
            const btn_toggler = document.getElementById('show-hide-password-toggler');
            const password_input = document.getElementById('password');

            btn_toggler.addEventListener('click', function (e) {

                if (e.target.classList.contains('fa-eye-slash')) {
                    e.target.classList.remove('fa-eye-slash');
                    e.target.classList.add('fa-eye');
                    password_input.type = 'text';
                }
                else {
                    e.target.classList.remove('fa-eye');
                    e.target.classList.add('fa-eye-slash');
                    password_input.type = 'password';
                }
            });
        }
        function showHidePass2() {
            const btn_toggler = document.getElementById('show-hide-password-toggler-2');
            const password_input = document.getElementById('password_confirmation');

            btn_toggler.addEventListener('click', function (e) {

                if (e.target.classList.contains('fa-eye-slash')) {
                    e.target.classList.remove('fa-eye-slash');
                    e.target.classList.add('fa-eye');
                    password_input.type = 'text';
                }
                else {
                    e.target.classList.remove('fa-eye');
                    e.target.classList.add('fa-eye-slash');
                    password_input.type = 'password';
                }
            });
        }

        const clearErrors = ()=>{
            const errors = document.querySelectorAll('.error-container');

            errors.forEach(item => {
                item.textContent = "";
            });
        }
    </script>
</x-auth-layout>