<x-app-layout title="{{ $title }}">
    <x-header />
    <main class="">
        {{ $slot }}
    </main>
    <footer class="p-[1em] bg-violet-900 w-full">
        <div class="text-center">
            <span class="text-gray-200">© {{ Carbon\Carbon::now()->year }} Abaca Classification System. All rights
                reserved.</span>
        </div>
    </footer>
</x-app-layout>
