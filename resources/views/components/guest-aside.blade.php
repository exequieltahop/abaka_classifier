<aside class="d-none d-sm-block" style="width: fit-content;">
    <div class="d-flex justify-content-center w-100">
        <img src="" alt="" style="width: 50px; height: 50px;">
    </div>
    <nav>
        <ul class="nav flex-col gap-2 mt-2 px-2">
            {{-- home --}}
            <li class="nav-item">
                <a href="{{route('home')}}"
                    class="nav-link text-nowrap w-100 text-secondary rounded {{ Route::currentRouteName() == 'home' ? 'bg-white shadow' : '' }}">
                    <x-icon type="home" />
                    Home
                </a>
            </li>
            {{-- more --}}
            <li class="nav-item">
                <div class="dropdown">
                    <a href="" class="nav-link text-nowrap w-100 text-secondary rounded " data-bs-toggle="dropdown">
                        <x-icon type="ellipsis" />
                        More
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item">
                            <a href="" class="text-decoration-none text-nowrap text-secondary ">
                                <x-icon type="sign-in" />
                                Sign In
                            </a>
                        </li>
                        <li class="dropdown-item">
                            <a href="" class="text-decoration-none text-nowrap text-secondary ">
                                <x-icon type="download" />
                                Install
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</aside>

<div class="offcanvas offcanvas-start" style="width: fit-content;" tabindex="-1" id="nav-mobile">
    <div class="offcanvas-body">
        <aside class="w-100">
            <div class="d-flex justify-content-center w-100">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <img src="" alt="" style="width: 50px; height: 50px;">
                    <button class="btn btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
            </div>
            <nav>
                <ul class="nav flex-col gap-2 mt-2 px-2">
                    {{-- home --}}
                    <li class="nav-item">
                        <a href="{{route('home')}}"
                            class="nav-link text-nowrap w-100 text-secondary rounded {{ Route::currentRouteName() == 'home' ? 'bg-white shadow' : '' }}">
                            <x-icon type="home" />
                            Home
                        </a>
                    </li>
                    {{-- more --}}
                    <li class="nav-item">
                        <div class="dropdown">
                            <a href="" class="nav-link text-nowrap w-100 text-secondary rounded " data-bs-toggle="dropdown">
                                <x-icon type="ellipsis" />
                                More
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item">
                                    <a href="" class="text-decoration-none text-nowrap text-secondary ">
                                        <x-icon type="sign-in" />
                                        Sign In
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="" class="text-decoration-none text-nowrap text-secondary ">
                                        <x-icon type="download" />
                                        Install
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </aside>
    </div>
</div>