<x-auth-layout title="Home">

    <style>
        .edu-card:hover {
            transform: translateY(-3px);
            transition: transform 200ms ease-in;
        }
    </style>

    <div class="p-4 sm:p-0">
        <section class="container mx-auto sm:p-[1em] md:p-0">
            <div class="block space-y-3">

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

        {{-- educational purpose --}}
        <section class="container mx-auto bg-white border border-gray-300 shadow mt-[1em] rounded-md hidden sm:block">
            <div class="bg-violet-900 p-4 rounded-tl-md rounded-tr-md">
                <h1 class="text-white text-xl">
                    <i class="fa-solid fa-info-circle"></i>
                    Abaca Fibers
                </h1>
            </div>
            <div class="p-5 flex gap-5 flex-wrap justify-center" id="abaca-edu">
                {{-- dynamic rendering --}}
            </div>
        </section>

        {{-- carousel --}}

        <div class="relative w-full max-w-xl mx-auto overflow-hidden mt-5 block sm:hidden">
            <!-- Slides -->
            <div id="carousel" class="flex transition-transform duration-500">
            </div>

            <!-- Controls -->
            <button
                class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 text-white px-3 py-1 rounded" id="prev-btn">
                ❮
            </button>

            <button
                class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 text-white px-3 py-1 rounded" id="next-btn">
                ❯
            </button>
        </div>

    </div>

    @vite('resources/js/home.js')

</x-auth-layout>
