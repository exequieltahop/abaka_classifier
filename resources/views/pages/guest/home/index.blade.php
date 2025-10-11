<x-guest-layout title="Home">
    <section class="container mx-auto">
        <div class="block space-y-3 p-3">

            {{-- open camera --}}
            <video src="" autoplay playsinline id="video" class="block w-full border border-blue-500 h-[300px]"></video>

            {{-- take pic btn --}}
            <div class="flex justify-center gap-3 flex-wrap">

                {{-- take pic btn --}}
                <x-button id="take-pic-btn" button-class="btn-primary" icon="camera">Take Picture</x-button>

                <form action="" class="flex">
                    {{-- upload btn --}}
                    <label id="upload-pic-btn" for="upload-img" class="bg-primary-color text-white p-1 px-2 m-0 rounded cursor-pointer">
                        <x-icon type="upload"/>
                        Upload Picture
                    </label>

                    {{-- hidden input --}}
                    <input type="file" name="upload-img" id="upload-img" class="hidden m-0">
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
