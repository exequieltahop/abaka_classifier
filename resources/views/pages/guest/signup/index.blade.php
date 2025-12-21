<x-guest-layout title="Sign up">
    <div class="container-fluid overflow-auto"
        style="
                background-image: url({{ asset('images/signin-bg.jpg') }});
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                background-color: rgba(0, 0, 0, 0.8);
                background-blend-mode: darken;
                background-attachment: fixed;
            ">
        <section class="container mx-auto ">
            <div class="flex justify-center items-center h-screen">
                {{-- form --}}
                <form action="" id="form-signup" class="w-[90%] h-[95%] max-w-[550px] p-10 shadow-lg bg-white rounded-sm border border-gray-200 shadow overflow-y-auto">
                    @csrf
                    <fieldset>
                        <legend class="text-primary font-medium text-2xl mb-5 text-center">Abaca Classification System</legend>
    
                        {{-- fname --}}
                        <div class="mb-5">
                            <label for="fname" class="font-medium text-primary block">First Name</label>
                            <input type="text" name="fname" id="fname" class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-sm" placeholder="Enter First Name">
                            <small class="text-red-500 font-medium error-container error-fname"></small>
                        </div>
                        {{-- mmame --}}
                        <div class="mb-5">
                            <label for="mname" class="font-medium text-primary block">Middle Initial</label>
                            <input type="text" name="mname" id="mname" class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-sm" placeholder="Enter Middle Initial">
                            <small class="text-red-500 font-medium error-container error-mname"></small>
                        </div>
                        {{-- lname --}}
                        <div class="mb-5">
                            <label for="lname" class="font-medium text-primary block">Last Name</label>
                            <input type="text" name="lname" id="lname" class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-sm" placeholder="Enter Last Name">
                            <small class="text-red-500 font-medium error-container error-lname"></small>
                        </div>

                        {{-- brgy --}}
                        <div class="mb-5">
                            <label for="brgy" class="font-medium text-primary block">Barangay</label>

                            <select name="brgy" id="brgy" class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-sm">
                                <option value="">-- Select Barangay --</option>
                                <option value="brgy 1">brgy 1</option>
                                <option value="brgy 2">brgy 2</option>
                                <option value="brgy 3">brgy 3</option>
                                <option value="brgy 4">brgy 4</option>
                            </select>
                            <small class="text-red-500 font-medium error-container error-brgy"></small>
                        </div>

                        {{-- username --}}
                        <div class="mb-5">
                            <label for="username" class="font-medium text-primary block">Username</label>
                            <input type="text" name="username" id="username" class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-sm" placeholder="Enter Username">
                            <small class="text-red-500 font-medium error-container error-username"></small>
                        </div>
    
                        {{-- password --}}
                        <div class="mb-5">
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
                            <small class="text-red-500 font-medium error-container error-password"></small>
                        </div>

                        <div class="mb-5">
                            <label for="password_confirmation" class="font-medium text-primary block">Password Confirmation</label>
                            {{-- input and show/hide password --}}
                            <div class="flex items-center">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="block text-base w-full p-[0.5em] text-primary placeholder:text-primary border border-violet-800 focus:border-violet-800 focus:outline-none focus:ring-2 rounded-tl-sm rounded-bl-sm" placeholder="Must be the same with password"
                                    autocomplete="current-password">
    
                                {{-- show hide pass --}}
                                <div class="block border border-violet-800 p-[0.5em] border-l-0 cursor-pointer rounded-tr-sm rounded-br-sm" >
                                    <x-icon type="eye-slash text-primary" id="show-hide-password-toggler-2"/>
                                </div>
                            </div>
                            <small class="text-red-500 font-medium error-container error-password"></small>
                        </div>
        
                        

                        {{-- submit btn --}}
                        <x-button type="submit" button-class="btn-primary w-full mb-4 font-medium" id="submit-btn">
                            <x-icon type="check" />
                            Register
                        </x-button>

                        <div class="text-center">
                            <span class="text-primary">
                                Already have an account? <a href="{{route('signin')}}" class="font-medium">sign in here</a>
                            </span>
                        </div>
                    </fieldset>
                </form>
            </div>
        </section>
    </div>

    {{-- script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function(){

            // show hide password
            showHidePass();
            showHidePass2();

            // register
            registerUser();
        });

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
        function showHidePass2(){
            const btn_toggler = document.getElementById('show-hide-password-toggler-2');
            const password_input = document.getElementById('password_confirmation');

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

        const registerUser = ()=>{
            const form = document.getElementById('form-signup');

            form.addEventListener('submit', async function(e){
                e.preventDefault();
                const data = new FormData(e.target);
                const btn = document.getElementById('submit-btn');

                try {
                    btn.disabled = true;

                    await axios.post(`/signup/process`, data, {
                        headers: {
                            'X-CSRF-TOKEN': window.token,
                            'Accept': 'application/json'
                        }
                    });

                    btn.disabled = false;

                    Toastify({
                        text: "Successfully Registered an acccount",
                        duration: 2000,
                        newWindow: true,
                        close: true,
                        gravity: "top", 
                        position: "left",
                        stopOnFocus: true,
                        style: {
                            background: "rgb(100, 225, 100)",
                        },
                    }).showToast();

                    setInterval(() => {
                        window.location.href = '/home';
                    }, 1000);

                } catch (error) {
                    console.error(error);

                    if(error.response.data.errors) {
                        for (const [key,val] of Object.entries(error.response.data.errors)) {
                            const error_wrapper = document.querySelector(`.error-${key}`);
                            error_wrapper.textContent = val;
                        }
                        btn.disabled = false;
                        return;
                    }

                    Toastify({
                        text: "Server Error, Something went wrong",
                        duration: 2000,
                        newWindow: true,
                        close: true,
                        gravity: "top", 
                        position: "left",
                        stopOnFocus: true,
                        style: {
                            background: "rgb(225, 100, 100)",
                        },
                    }).showToast();

                    btn.disabled = false;
                    return;
                }                
            });
        }
    </script>
</x-guest-layout>
