<x-guest-layout title="Sign In">
    <section class="container mx-auto">
        <div class="flex justify-center">

            {{-- form --}}
            <form action="" id="form-signin" class="w-[90%] max-width-[500px] p-10 shadow-lg bg-white rounded-sm" style="max-width: 500px;">
                @csrf
                <fieldset>
                    <legend class="text-primary font-medium text-2xl mb-2">Sign In</legend>

                    {{-- email --}}
                    <div class="mb-3">
                        <label for="email" class="font-medium text-primary block">Email</label>
                        <input type="email" name="email" id="email" class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-sm" placeholder="email@example.com" autocomplete="email">
                    </div>

                    {{-- password --}}
                    <div class="mb-3">
                        <label for="password" class="font-medium text-primary block">Password</label>
                        {{-- input and show/hide password --}}
                        <div class="flex items-center">
                            <input type="password" name="password" id="password" class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-tl-sm rounded-bl-sm" placeholder="Atleast 8 Characters long"
                                autocomplete="current-password">

                            {{-- show hide pass --}}
                            <div class="block border border-violet-800 p-[0.5em] border-l-0 cursor-pointer rounded-tr-sm rounded-br-sm" >
                                <x-icon type="eye-slash text-primary" id="show-hide-password-toggler"/>
                            </div>

                        </div>
                    </div>

                    {{-- remember me --}}
                    <div class="mb-3 flex align-center space-x-1">
                        <input type="checkbox" name="remember_me" id="remember_me">
                        <label for="remember_me" class="text-sm font-medium text-primary">Remember me</label>
                    </div>

                    {{-- submit btn --}}
                    <x-button type="submit" button-class="btn-primary" id="submit-btn">
                        <x-icon type="check" />
                        Sign In
                    </x-button>
                </fieldset>
            </form>
        </div>
    </section>

    {{-- script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            // sign in
            signin();

            // show hide password
            showHidePass();
        });

        // sign in
        function signin(){
            const form = document.getElementById('form-signin');
            const submit_btn = document.getElementById('submit-btn');

            form.addEventListener('submit', async function(e){
                e.preventDefault();

                submit_btn.disabled = true;
                submit_btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing';
                try {
                    // url and post request
                    const url = `{{route('signin.process')}}`;
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json'
                        },
                        body: new FormData(form)
                    });

                    console.log(response.status);


                    // check status code
                    if(response.status == 500){
                        throw new Error("");
                    }
                    else if(response.status == 422){
                        Swal.fire({
                            title: 'Unauthorized',
                            icon: 'warning',
                            text: 'Email and Password are required'
                        }).then(()=>{
                            submit_btn.disabled = false;
                            return;
                        });
                    }

                    else if (response.status == 401){ // if 401 then unauthorized
                        Swal.fire({
                            title: 'Unauthorized',
                            icon: 'warning',
                            text: 'Invalid Credentials'
                        }).then(()=>{
                            submit_btn.disabled = false;
                            submit_btn.innerHTML = '<i class="fa-solid fa-check"></i> Sign In';
                            return;
                        });
                    } else if (response.status == 200){ // if 200 then ok
                        Swal.fire({
                            title: 'Success',
                            icon: 'success',
                            text: 'Successfully Sign In'
                        }).then(()=>{
                            submit_btn.disabled = false;
                            submit_btn.innerHTML = '<i class="fa-solid fa-check"></i> Sign In';
                            window.location.href = '{{route('home')}}';
                        });
                    }

                } catch (error) {
                    // if error
                    submit_btn.disabled = false;
                    submit_btn.innerHTML = '<i class="fa-solid fa-check"></i> Sign In';
                    console.error(error.message);
                    Swal.fire({
                        title: 'Error',
                        icon: 'error',
                        text: 'Something Went Wrong, Pls Contact Developer'
                    });
                    return;
                }
            });
        }

        // show hide password
        function showHidePass(){
            const btn_toggler = document.getElementById('show-hide-password-toggler');
            const password_input = document.getElementById('password');

            btn_toggler.addEventListener('click', function(e){

                if(e.target.classList.contains('fa-eye-slash')) {
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
    </script>
</x-guest-layout>