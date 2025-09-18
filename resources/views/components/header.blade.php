<header class="container-fluid h-16 bg-white mb-3 shadow-lg">
    <div class="flex items-center h-full px-3">
        <div class="container mx-auto flex items-center justify-center sm:justify-start space-x-3 relative">

            {{-- mobile nav view toggler --}}
            <button type="button" command="--toggle" commandfor="mobile-menu"
                class="block sm:hidden absolute inset-y-0 left-0">
                <x-icon type="bars text-violet-900 cursor-pointer" command="--toggle" commandfor="mobile-menu" />
            </button>

            {{-- brand --}}
            <a href="#" class="text-black-200 font-bold text-violet-900 uppercase block sm:hidden">Abaca Classification System</a>
            <a href="#" class="text-black-200 font-bold text-violet-900 uppercase hidden sm:block">ACS</a>

            {{-- nav --}}
            <nav class="hidden sm:flex align-center space-x-4">
                <a href="{{route('home')}}" class="block px-5 py-1 font-medium rounded-sm {{Route::currentRouteName() == 'home' ? 'text-white bg-violet-900' : 'text-primary' }}">
                    <x-icon type="home"/>
                    Home
                </a>
                @guest
                    <a href="{{route('signin')}}"
                        class="block px-5 py-1 font-medium rounded-sm {{Route::currentRouteName() == 'signin' ? 'text-white bg-violet-900' : 'text-primary' }}">
                        <x-icon type="sign-in"/>
                        Sign In
                    </a>
                @endguest

                @auth
                    <a href="{{route('logs.index')}}"
                        class="block px-5 py-1 font-medium rounded-sm {{Route::currentRouteName() == 'logs.index' ? 'text-white bg-violet-900' : 'text-primary' }}">
                        <x-icon type="history"/>
                        Logs
                    </a>

                    <a href="{{route('signout')}}"
                        class="block px-5 py-1 font-medium rounded-sm text-primary">
                        <x-icon type="sign-out"/>
                        Sign out
                    </a>
                @endauth
            </nav>
        </div>
    </div>

    {{-- mobile view --}}
    <el-disclosure id="mobile-menu" hidden class="block sm:hidden px-3 bg-white m-0 shadow-lg absolute z-50 w-full">
        <div class="space-y-1 py-2">
            <a href="{{route('home')}}" class="block px-5 py-1 font-medium rounded-sm {{Route::currentRouteName() == 'home' ? 'text-white bg-violet-900' : 'text-primary'}}">
                <x-icon type="home"/>
                Home
            </a>

            @guest
                <a href="{{route('signin')}}" class="block px-5 py-1 font-medium rounded-sm {{Route::currentRouteName() == 'signin' ? 'text-white bg-violet-900' : 'text-primary'}}">
                    <x-icon type="sign-in"/>
                    Sign In
                </a>
            @endguest
            @auth
                <a href="{{route('logs.index')}}"
                    class="block px-5 py-1 font-medium rounded-sm {{Route::currentRouteName() == 'logs.index' ? 'text-white bg-violet-900' : 'text-primary'}}">
                    <x-icon type="history"/>
                    Logs
                </a>
                <a href="{{route('signout')}}" class="block px-5 py-1 font-medium rounded-sm text-primary">
                    <x-icon type="sign-out"/>
                    Sign Out
                </a>
            @endauth
        </div>
    </el-disclosure>
</header>