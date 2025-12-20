<x-auth-layout title="Home">
    <section class="container mx-auto">
        <div class="block space-y-3 p-3">

            {{-- open camera --}}
            <video src="" autoplay playsinline id="video"
                class="block w-full border border-blue-500 h-[300px]"></video>

            {{-- img uploaded preview --}}
            <div class="flex justify-center">
                <div id="image-preview" class="w-full rounded max-w-[500px] bg-white hidden shadow-lg p-4">

                    <img src="" alt="" id="img-preview" class="w-full" style="aspect-ratio: 1;">

                    <h4 class="font-medium text-primary text-center" id="predicted-class">Class Predicted: </h4>

                    <div id="fiber-description"
                         class="mt-4 p-4 bg-white rounded shadow text-sm border border-gray-200 hidden">
                    </div>

                </div>
            </div>

            {{-- take pic btn --}}
            <div class="flex justify-center gap-3 flex-wrap">

                <x-button id="take-pic-btn" button-class="btn-primary" icon="camera">Take Picture</x-button>

                <form action="" class="flex">
                    <label id="upload-pic-btn" for="upload-img"
                        class="bg-primary-color text-white p-1 px-2 m-0 rounded cursor-pointer">
                        <x-icon type="upload" />
                        Upload Picture
                    </label>

                    <input type="file" name="upload-img" id="upload-img" class="hidden m-0">
                </form>

            </div>
        </div>
    </section>

    @vite('resources/js/home.js')

</x-auth-layout>
