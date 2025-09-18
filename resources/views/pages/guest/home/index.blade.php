<x-guest-layout title="Home">
    <section class="container mx-auto">
        <div class="block space-y-3 p-3">
            {{-- open camera --}}
            <video src="" autoplay playsinline id="video" class="block w-full border border-blue-500 h-[300px]"></video>
            {{-- take pic btn --}}
            <div class="flex justify-center">
                <x-button id="take-pic-btn" button-class="btn-primary" icon="camera">Take Picture</x-button>
            </div>
        </div>
    </section>
</x-guest-layout>