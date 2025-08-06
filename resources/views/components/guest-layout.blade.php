<x-app-layout title="{{$title}}">
    <div class="d-flex">
        <x-guest-aside/>
        <main class="container-fluid p-2">
            <x-header/>
            {{$slot}}
        </main>
    </div>
    <footer></footer>
</x-app-layout>