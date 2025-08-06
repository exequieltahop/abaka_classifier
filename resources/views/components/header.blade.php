<header class="bg-white rounded p-3 w-100 shadow mb-3">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <x-icon type="bars text-secondary m-0 d-block d-sm-none cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#nav-mobile"/>
            <h5 class="text-secondary m-0">Abaca Classification System</h5>
        </div>
        {{-- if admin --}}
        @if (auth()->user())
            <img src="" alt="user" class="border border-danger rounded-pill" style="width: 50px; height: 50px;">
        @endif
    </div>
</header>