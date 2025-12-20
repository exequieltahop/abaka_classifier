<header class="container-fluid h-16 mb-3 shadow-lg bg-violet-900">
    <div class="flex items-center h-full px-3">
        <div class="container mx-auto flex items-center justify-center lg:justify-start space-x-3 relative">

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
                <a href="{{ route('home') }}"
                    class="block px-5 py-1 text-white rounded-sm  {{ Route::currentRouteName() == 'home' ? 'font-bold' : '' }}">
                    <x-icon type="home" />
                    Home
                </a>
                @guest
                    <a href="{{ route('signin') }}"
                        class="block px-5 py-1 text-white rounded-sm  {{ Route::currentRouteName() == 'signin' ? 'font-bold' : '' }}">
                        <x-icon type="sign-in" />
                        Sign In
                    </a>
                @endguest

                @auth
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

                    <a href="{{ route('signout') }}" class="block px-5 py-1 text-white rounded-sm  ">
                        <x-icon type="sign-out" />
                        Sign out
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
    <el-disclosure id="mobile-menu" hidden class="block lg:hidden px-3 bg-violet-900 m-0 shadow-lg absolute z-50 w-full">
        <div class="space-y-1 py-2">
            <a href="{{ route('home') }}"
                class="block px-5 py-1  text-white rounded-sm {{ Route::currentRouteName() == 'home' ? 'text-white font-medium' : '' }}">
                <x-icon type="home" />
                Home
            </a>

            @guest
                <a href="{{ route('signin') }}"
                    class="block px-5 py-1  text-white rounded-sm {{ Route::currentRouteName() == 'signin' ? 'text-white font-medium' : '' }}">
                    <x-icon type="sign-in" />
                    Sign In
                </a>
            @endguest
            @auth
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
