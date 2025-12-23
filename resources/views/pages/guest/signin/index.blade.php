<x-guest-layout title="Sign In">
    <div class="container-fluid" style="
                background-image: url({{ asset('images/signin-bg.jpg') }});
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                background-color: rgba(0, 0, 0, 0.8);
                background-blend-mode: darken;
                background-attachment: fixed;
            ">
        <section class="container mx-auto">
            <div class="flex justify-center items-center h-screen">

                {{-- form --}}
                <form action="" id="form-signin"
                    class="w-[90%] max-w-[550px] p-10 shadow-lg bg-white rounded-sm border border-gray-200 shadow">
                    @csrf
                    <fieldset>
                        <legend class="text-primary font-medium text-2xl mb-2 text-center">Abaca Classification System
                        </legend>

                        {{-- username --}}
                        <div class="mb-3">
                            <label for="username" class="font-medium text-primary block">Username</label>
                            <input type="text" name="username" id="username"
                                class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-sm"
                                placeholder="Username" autocomplete="username">
                            <small class="text-red-500 font-medium text error-container error-username"></small>
                        </div>

                        {{-- password --}}
                        <div class="mb-3">
                            <label for="password" class="font-medium text-primary block">Password</label>
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
                            <small class="text-red-500 font-medium text error-container error-password"></small>
                        </div>

                        {{-- remember me --}}
                        <div class="mb-3 flex align-center space-x-1">
                            <input type="checkbox" name="remember_me" id="remember_me">
                            <label for="remember_me" class="text-sm font-medium text-primary">Remember me</label>
                        </div>

                        {{-- submit btn --}}
                        <x-button type="submit" button-class="btn-primary w-full mb-4 font-medium" id="submit-btn">
                            <x-icon type="sign-in" />
                            Sign In
                        </x-button>

                        <div class="text-center">
                            <span class="text-primary">
                                Dont have an account? <a href="{{ route('signup') }}" class="font-medium">sign up
                                    here</a>
                            </span>
                        </div>
                    </fieldset>
                </form>
            </div>
        </section>
    </div>

    {{-- script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            signin();
            showHidePass();
        });

        // sign in
        function signin() {
            const form = document.getElementById('form-signin');
            const submit_btn = document.getElementById('submit-btn');

            if (!form || !submit_btn) return;

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                submit_btn.disabled = true;
                submit_btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing';

                try {

                    clearErrors();

                    const url = `{{ route('signin.process') }}`;

                    await axios.post(url, new FormData(form), {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    Toastify({
                        text: 'Successfully login',
                        duration: 2000,
                        gravity: "top",
                        position: 'left',
                        style: {
                            background: "rgb(100, 225, 100)"
                        }
                    }).showToast();

                    setTimeout(() => {
                        submit_btn.disabled = false;
                        submit_btn.innerHTML = '<i class="fa-solid fa-check"></i> Sign In';
                        window.location.href = "/home";
                    }, 1000);

                } catch (error) {
                    console.error(error);

                    submit_btn.disabled = false;
                    submit_btn.innerHTML = '<i class="fa-solid fa-check"></i> Sign In';

                    if (error.response?.status === 401) {
                        Toastify({
                            text: "Warning, Invalid Account",
                            duration: 2000,
                            gravity: "top",
                            position: "left",
                            close: true,
                            style: {
                                background: "rgb(249, 255, 143)",
                                color: "black"
                            }
                        }).showToast();

                        return;
                    }

                    if (error.response?.status === 422) {
                        const errors = error.response.data.errors;

                        Object.entries(errors).map(([key, val]) => {
                            document.querySelector(`.error-${key}`).textContent = val.join(', ');
                        });

                        return;
                    }

                    Toastify({
                        text: "Server Error, Something went wrong",
                        duration: 2000,
                        gravity: "top",
                        position: "left",
                        style: {
                            background: "rgb(225,100,100)"
                        }
                    }).showToast();
                }
            }); // <-- close addEventListener here
        } // <-- close signin function

        // show hide password
        function showHidePass() {
            const btn_toggler = document.getElementById('show-hide-password-toggler');
            const password_input = document.getElementById('password');

            if (!btn_toggler || !password_input) return;

            btn_toggler.addEventListener('click', function (e) {
                if (e.target.classList.contains('fa-eye-slash')) {
                    e.target.classList.replace('fa-eye-slash', 'fa-eye');
                    password_input.type = 'text';
                } else {
                    e.target.classList.replace('fa-eye', 'fa-eye-slash');
                    password_input.type = 'password';
                }
            });
        }

        // clear errors
        const clearErrors = () => {
            const error_containers = document.querySelectorAll('.error-container');

            error_containers.forEach(item => {
                item.textContent = "";
            });
        }
    </script>

</x-guest-layout>