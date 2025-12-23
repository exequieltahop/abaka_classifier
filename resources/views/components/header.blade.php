<header class="container-fluid h-16 mb-3 shadow-lg bg-violet-900 sticky top-0">
    <div class="flex items-center h-full px-3">
        <div class="container mx-auto flex items-center justify-center lg:justify-start space-x-3 relative">

            <x-icon
                type="user-circle text-white text-4xl absolute top-1/2 right-0 transform -translate-y-1/2 cursor-pointer user-toggler" />

            @if (auth()->user()->role == 3)
                <a href="{{ route('notifications.index') }}"
                    class="text-white absolute top-1/2 right-[65px] transform -translate-y-1/2 cursor-pointer">
                    <x-icon type="bell " title="Notifications" />
                </a>
                <small class="absolute top-[5px] right-[45px] block bg-red-500 text-white p-1 rounded-xl"
                    id="notif-count">
                </small>
            @endif

            {{-- dropdown --}}
            <div class="absolute top-[100%] right-0 hidden border border-gray-200" id="drop">
                <ul class="bg-violet-900 text-white">
                    <li class="">
                        <a href="{{ route('account-setting.index') }}" class="block p-3">
                            <x-icon type="user" />
                            Account Setting
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('signout') }}" class="block p-3 cursor-pointer">
                            <x-icon type="arrow-left" />
                            Sign Out
                        </a>
                    </li>
                </ul>
            </div>

            {{-- mobile nav view toggler --}}
            <button type="button" command="--toggle" commandfor="mobile-menu"
                class="block lg:hidden absolute inset-y-0 left-0">
                <x-icon type="bars text-white cursor-pointer" command="--toggle" commandfor="mobile-menu" />
            </button>

            {{-- brand --}}
            <span class="text-black-200 font-bold text-violet-900 uppercase block lg:hidden">
                Abaca Classification System
            </span>

            <a href="{{ route('home') }}" class="text-black-200 font-bold text-violet-900 uppercase hidden lg:block">
                <img src="{{ asset('images/logo.png') }}" alt="img" style="height: 50px">
            </a>

            {{-- nav --}}
            <nav class="hidden lg:flex align-center space-x-4">

                @guest
                    <a href="{{ route('signin') }}"
                        class="block px-5 py-1 text-white rounded-sm  {{ Route::currentRouteName() == 'signin' ? 'font-bold' : '' }}">
                        <x-icon type="sign-in" />
                        Sign In
                    </a>
                @endguest

                @auth
                    <a href="{{ route('home') }}"
                        class="block px-5 py-1 text-white rounded-sm  {{ Route::currentRouteName() == 'home' ? 'font-bold' : '' }}">
                        <x-icon type="home" />
                        Home
                    </a>

                    @if (auth()->user()->role != 3)
                        <a href="{{ route('reports.index') }}"
                            class="block px-5 py-1 text-white rounded-sm  {{ str_contains(Route::currentRouteName(), 'reports') ? 'font-bold' : '' }}">
                            <x-icon type="bar-chart" />
                            Reports
                        </a>
                    @endif

                    @if (Auth::user()->role == 1)
                        <a href="{{ route('users.index') }}"
                            class="block px-5 py-1 text-white rounded-sm  {{ str_contains(Route::currentRouteName(), 'users') ? 'font-bold' : '' }}">
                            <x-icon type="users" />
                            Users
                        </a>
                    @endif
                    <a href="{{ route('inferenced-images.index') }}"
                        class="block px-5 py-1 text-white rounded-sm  {{ str_contains(Route::currentRouteName(), 'inferenced-images') ? 'font-bold' : '' }}">
                        <x-icon type="history" />
                        Inferenced Images
                    </a>

                @endauth

                <button type="button" class="install-pwa block px-5 py-1 text-white rounded-sm   hidden">
                    <x-icon type="download text-primary" />
                    Install
                </button>

            </nav>
        </div>
    </div>

    {{-- mobile view --}}
    <el-disclosure id="mobile-menu" hidden
        class="block lg:hidden px-3 bg-violet-900 m-0 shadow-lg absolute z-50 w-full">
        <div class="space-y-1 py-2">


            @guest
                <a href="{{ route('signin') }}"
                    class="block px-5 py-1  text-white rounded-sm {{ Route::currentRouteName() == 'signin' ? 'text-white font-medium' : '' }}">
                    <x-icon type="sign-in" />
                    Sign In
                </a>
            @endguest
            @auth
                <a href="{{ route('home') }}"
                    class="block px-5 py-1  text-white rounded-sm {{ Route::currentRouteName() == 'home' ? 'text-white font-medium' : '' }}">
                    <x-icon type="home" />
                    Home
                </a>
                @if (auth()->user()->role != 3)
                        <a href="{{ route('users.index') }}"
                            class="block px-5 py-1 text-white rounded-sm  {{ str_contains(Route::currentRouteName(), 'users') ? 'font-bold' : '' }}">
                            <x-icon type="bar-chart" />
                            Reports
                        </a>
                    @endif
                @if (Auth::user()->role == 1)
                    <a href="{{ route('users.index') }}"
                        class="block px-5 py-1  text-white rounded-sm {{ str_contains(Route::currentRouteName(), 'users') ? 'text-white font-medium' : '' }}">
                        <x-icon type="users" />
                        Users
                    </a>
                @endif

                <a href="{{ route('inferenced-images.index') }}"
                    class="block px-5 py-1  text-white rounded-sm {{ str_contains(Route::currentRouteName(), 'inferenced-images') ? 'text-white font-medium' : '' }}">
                    <x-icon type="history" />
                    Inferenced Images
                </a>
                <a href="{{ route('signout') }}" class="block px-5 py-1  text-white rounded-sm ">
                    <x-icon type="sign-out" />
                    Sign Out
                </a>
            @endauth
            <button type="button" class="install-pwa block px-5 py-1  text-white rounded-sm  hidden">
                <x-icon type="download text-white" />
                Install
            </button>
        </div>
    </el-disclosure>

</header>

{{-- script --}}
@auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            /**
             * user dropdown for accoun setting and sign out
             */
            userDropdown();

            /**
             * every 1s call func
             */
            @if (auth()->user()->role == 3)
                setInterval(() => {
                    getNotificationCount();
                }, 1000);
            @endif
        });

        // show hide user dropdown
        const userDropdown = () => {
            const toggler = document.querySelector('.user-toggler');

            toggler.addEventListener('click', function(e) {
                e.stopImmediatePropagation();

                const dropdown = document.getElementById('drop');

                if (dropdown.classList.contains('hidden')) dropdown.classList.remove('hidden');
                else dropdown.classList.add('hidden');

            });
        }

        // get notification
        const getNotificationCount = async () => {
            try {
                const response = await axios.get(`/user-notification-count`);

                const count = response.data.data;

                document.getElementById('notif-count').textContent = count;
            } catch (error) {
                console.error(error);
                Toastify({
                    text: 'Server Error',
                    duration: 2000,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "left",
                    stopOnFocus: true,
                    style: {
                        background: "rgb(255, 100, 100)"
                    }
                }).showToast();
            }
        }
    </script>
@endauth
