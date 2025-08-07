<x-guest-layout title="Sign In">
    <section class="container-fluid p-0 bg-white shadow-lg d-flex justify-content-center h-100 rounded">
        <form action="" id="form-signin" class="w-100 p-4" style="max-width: 500px;">
            @csrf
            <fieldset>
                <legend>Sign In</legend>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" autocomplete="email" required>
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                        autocomplete="current-password" minlength="8" required>
                </div>

                <button class="btn btn-sm btn-primary" type="submit" id="submit-btn">
                    <x-icon type="check" />
                    Submit
                </button>
            </fieldset>
        </form>
    </section>

    {{-- script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            // sign in
            signin();
        });

        // sign in
        function signin(){
            const form = document.getElementById('form-signin');
            const submit_btn = document.getElementById('submit-btn');

            form.addEventListener('submit', async function(e){
                e.preventDefault();

                submit_btn.disabled = true;
                try {
                    // url and post request
                    const url = `{{route('signin.process')}}`;
                    const response = await fetch(url, {
                        method: 'POST',
                        body: new FormData(form)
                    });

                    // check status code
                    if(response.status == 500){
                        throw new Error("");
                    }else if (response.status == 401){ // if 401 then unauthorized
                        Swal.fire({
                            title: 'Unauthorized',
                            icon: 'warning',
                            text: 'Invalid Credentials'
                        }).then(()=>{
                            submit_btn.disabled = false;
                        });
                    } else if (response.status == 200){ // if 200 then ok
                        Swal.fire({
                            title: 'Success',
                            icon: 'success',
                            text: 'Successfully Sign In'
                        }).then(()=>{
                            submit_btn.disabled = false;
                        });
                    }

                } catch (error) {
                    // if error
                    submit_btn.disabled = false;
                    console.error(error.message);
                    Swal.fire({
                        title: 'Error',
                        icon: 'error',
                        text: 'Something Went Wrong, Pls Contact Developer'
                    });
                }
            });
        }
    </script>
</x-guest-layout>